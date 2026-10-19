<?php

namespace App\Livewire\Admin;

use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Testimonials extends Component
{
    use WithFileUploads;

    public string $section_kicker = '';

    public string $section_title = '';

    public string $section_description = '';

    public ?int $editingId = null;

    public string $name = '';

    public string $role = '';

    public string $text = '';

    public string $image_url = '';

    public $image_upload = null;

    public int $rating = 5;

    public bool $is_active = true;

    public bool $showForm = false;

    public function mount(): void
    {
        $intro = array_merge(
            SiteSetting::testimonialIntroDefaults(),
            SiteSetting::getValue('testimonials_intro', [])
        );

        $this->section_kicker = (string) ($intro['kicker'] ?? '');
        $this->section_title = (string) ($intro['title'] ?? '');
        $this->section_description = (string) ($intro['description'] ?? '');
    }

    public function saveSection(): void
    {
        $this->validate([
            'section_kicker' => ['required', 'string', 'max:80'],
            'section_title' => ['required', 'string', 'max:150'],
            'section_description' => ['required', 'string', 'max:500'],
        ]);

        SiteSetting::putValue('testimonials_intro', [
            'kicker' => $this->section_kicker,
            'title' => $this->section_title,
            'description' => $this->section_description,
        ]);

        $this->dispatch('toast', message: 'Testimonials section saved', type: 'success');
    }

    public function toggleForm(): void
    {
        $this->showForm = ! $this->showForm;
    }

    public function edit(int $id): void
    {
        $item = Testimonial::findOrFail($id);

        $this->editingId = $item->id;
        $this->name = $item->name;
        $this->role = $item->role ?? '';
        $this->text = $item->text;
        $this->image_url = (is_string($item->image) && str_starts_with($item->image, 'http'))
            ? $item->image
            : '';
        $this->image_upload = null;
        $this->rating = (int) $item->rating;
        $this->is_active = $item->is_active;
        $this->showForm = true;
        $this->resetValidation();
    }

    public function resetForm(): void
    {
        $this->reset([
            'editingId',
            'name',
            'role',
            'text',
            'image_url',
            'image_upload',
        ]);

        $this->rating = 5;
        $this->is_active = true;
        $this->showForm = false;
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'role' => ['nullable', 'string', 'max:80'],
            'text' => ['required', 'string', 'min:10', 'max:1000'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'image_upload' => ['nullable', 'image', 'max:4096'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'is_active' => ['boolean'],
        ]);

        $data = [
            'name' => $this->name,
            'role' => $this->role !== '' ? $this->role : null,
            'text' => $this->text,
            'rating' => $this->rating,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            $item = Testimonial::findOrFail($this->editingId);
            $item->update($data);
            $message = 'Testimonial updated';
        } else {
            $data['sort_order'] = ((int) Testimonial::max('sort_order')) + 1;
            $item = Testimonial::create($data);
            $message = 'Testimonial added';
        }

        if ($this->image_upload) {
            if ($item->image && ! str_starts_with($item->image, 'http')) {
                Storage::disk('public')->delete($item->image);
            }

            $path = $this->image_upload->store('testimonials', 'public');
            $item->update(['image' => $path]);
        } elseif ($this->image_url !== '' && str_starts_with($this->image_url, 'http')) {
            $item->update(['image' => $this->image_url]);
        }

        $this->edit($item->id);
        $this->dispatch('toast', message: $message, type: 'success');
    }

    public function delete(int $id): void
    {
        $item = Testimonial::findOrFail($id);

        if ($item->image && ! str_starts_with($item->image, 'http')) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        $this->dispatch('toast', message: 'Testimonial deleted', type: 'success');
    }

    public function move(int $id, string $direction): void
    {
        $items = Testimonial::orderBy('sort_order')->orderBy('id')->get()->values();
        $index = $items->search(fn (Testimonial $item) => $item->id === $id);

        if ($index === false) {
            return;
        }

        $swapWith = $direction === 'up' ? $index - 1 : $index + 1;

        if (! isset($items[$swapWith])) {
            return;
        }

        $current = $items[$index];
        $other = $items[$swapWith];
        $currentOrder = $current->sort_order;
        $current->update(['sort_order' => $other->sort_order]);
        $other->update(['sort_order' => $currentOrder]);

        $this->dispatch('toast', message: 'Order updated', type: 'success');
    }

    public function toggleActive(int $id): void
    {
        $item = Testimonial::findOrFail($id);
        $item->update(['is_active' => ! $item->is_active]);

        $this->dispatch(
            'toast',
            message: $item->is_active ? 'Testimonial activated' : 'Testimonial hidden',
            type: 'success'
        );
    }

    public function render()
    {
        return view('livewire.admin.testimonials', [
            'testimonials' => Testimonial::orderBy('sort_order')->orderBy('id')->get(),
        ])->layout('layouts.admin', [
            'title' => 'Testimonials',
        ]);
    }
}
