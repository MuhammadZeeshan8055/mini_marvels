<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Categories extends Component
{
    public ?int $editingId = null;

    public string $name = '';

    public string $emoji = '';

    public function edit(int $id): void
    {
        $category = Category::findOrFail($id);

        $this->editingId = $category->id;
        $this->name = $category->name;
        $this->emoji = $category->emoji ?? '';
    }

    public function resetForm(): void
    {
        $this->reset('editingId', 'name', 'emoji');
        $this->resetValidation();
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'emoji' => ['nullable', 'string', 'max:10'],
        ]);

        $slug = Str::slug($validated['name']);

        if ($this->editingId) {
            $category = Category::findOrFail($this->editingId);
            $category->update([
                'name' => $validated['name'],
                'slug' => $slug,
                'emoji' => $validated['emoji'] ?: null,
            ]);

            $this->dispatch('toast', message: 'Category updated', type: 'success');
        } else {
            Category::create([
                'name' => $validated['name'],
                'slug' => $slug,
                'emoji' => $validated['emoji'] ?: null,
            ]);

            $this->dispatch('toast', message: 'Category added', type: 'success');
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $category = Category::findOrFail($id);

        if ($category->products()->exists()) {
            $this->dispatch('toast', message: 'Cannot delete category with products', type: 'error');

            return;
        }

        $category->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        $this->dispatch('toast', message: 'Category deleted', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.categories', [
            'categories' => Category::withCount('products')->orderBy('name')->get(),
        ])->layout('layouts.admin', [
            'title' => 'Categories',
        ]);
    }
}
