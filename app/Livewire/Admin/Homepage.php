<?php

namespace App\Livewire\Admin;

use App\Models\HeroSlide;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Homepage extends Component
{
    use WithFileUploads;

    public ?int $editingId = null;

    public string $eyebrow = '';

    public string $title = '';

    public string $text = '';

    public string $button_label = 'Shop Now';

    public string $button_url = '#products';

    public string $image_url = '';

    public $image_upload = null;

    public bool $title_dark = false;

    public bool $eyebrow_box = false;

    public bool $is_active = true;

    public bool $showForm = false;

    public function toggleForm(): void
    {
        $this->showForm = ! $this->showForm;
    }

    public function edit(int $id): void
    {
        $slide = HeroSlide::findOrFail($id);

        $this->editingId = $slide->id;
        $this->eyebrow = $slide->eyebrow ?? '';
        $this->title = $slide->title;
        $this->text = $slide->text ?? '';
        $this->button_label = $slide->button_label ?: 'Shop Now';
        $this->button_url = $slide->button_url ?: '#products';
        $this->image_url = (is_string($slide->image) && str_starts_with($slide->image, 'http'))
            ? $slide->image
            : '';
        $this->image_upload = null;
        $this->title_dark = $slide->title_dark;
        $this->eyebrow_box = $slide->eyebrow_box;
        $this->is_active = $slide->is_active;
        $this->showForm = true;
        $this->resetValidation();
    }

    public function resetForm(): void
    {
        $this->reset([
            'editingId',
            'eyebrow',
            'title',
            'text',
            'image_url',
            'image_upload',
            'title_dark',
            'eyebrow_box',
        ]);

        $this->button_label = 'Shop Now';
        $this->button_url = '#products';
        $this->is_active = true;
        $this->showForm = false;
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate([
            'eyebrow' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'min:2', 'max:200'],
            'text' => ['nullable', 'string', 'max:1000'],
            'button_label' => ['required', 'string', 'max:60'],
            'button_url' => ['required', 'string', 'max:500'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'image_upload' => ['nullable', 'image', 'max:4096'],
            'title_dark' => ['boolean'],
            'eyebrow_box' => ['boolean'],
            'is_active' => ['boolean'],
        ]);

        $data = [
            'eyebrow' => $this->eyebrow !== '' ? $this->eyebrow : null,
            'title' => $this->title,
            'text' => $this->text !== '' ? $this->text : null,
            'button_label' => $this->button_label,
            'button_url' => $this->button_url,
            'title_dark' => $this->title_dark,
            'eyebrow_box' => $this->eyebrow_box,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            $slide = HeroSlide::findOrFail($this->editingId);
            $slide->update($data);
            $message = 'Hero slide updated';
        } else {
            $data['sort_order'] = ((int) HeroSlide::max('sort_order')) + 1;
            $slide = HeroSlide::create($data);
            $message = 'Hero slide added';
        }

        if ($this->image_upload) {
            if ($slide->image && ! str_starts_with($slide->image, 'http')) {
                Storage::disk('public')->delete($slide->image);
            }

            $path = $this->image_upload->store('hero', 'public');
            $slide->update(['image' => $path]);
        } elseif ($this->image_url !== '' && str_starts_with($this->image_url, 'http')) {
            $slide->update(['image' => $this->image_url]);
        }

        $this->edit($slide->id);
        $this->dispatch('toast', message: $message, type: 'success');
    }

    public function delete(int $id): void
    {
        $slide = HeroSlide::findOrFail($id);

        if ($slide->image && ! str_starts_with($slide->image, 'http')) {
            Storage::disk('public')->delete($slide->image);
        }

        $slide->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        $this->dispatch('toast', message: 'Hero slide deleted', type: 'success');
    }

    public function move(int $id, string $direction): void
    {
        $slides = HeroSlide::orderBy('sort_order')->orderBy('id')->get()->values();
        $index = $slides->search(fn (HeroSlide $slide) => $slide->id === $id);

        if ($index === false) {
            return;
        }

        $swapWith = $direction === 'up' ? $index - 1 : $index + 1;

        if (! isset($slides[$swapWith])) {
            return;
        }

        $current = $slides[$index];
        $other = $slides[$swapWith];

        $currentOrder = $current->sort_order;
        $current->update(['sort_order' => $other->sort_order]);
        $other->update(['sort_order' => $currentOrder]);

        $this->dispatch('toast', message: 'Slide order updated', type: 'success');
    }

    public function toggleActive(int $id): void
    {
        $slide = HeroSlide::findOrFail($id);
        $slide->update(['is_active' => ! $slide->is_active]);

        $this->dispatch(
            'toast',
            message: $slide->is_active ? 'Slide activated' : 'Slide hidden',
            type: 'success'
        );
    }

    public function render()
    {
        return view('livewire.admin.homepage', [
            'slides' => HeroSlide::orderBy('sort_order')->orderBy('id')->get(),
        ])->layout('layouts.admin', [
            'title' => 'Homepage',
        ]);
    }
}
