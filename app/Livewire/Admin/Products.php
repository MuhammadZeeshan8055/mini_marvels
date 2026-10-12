<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    public ?int $editingId = null;

    public string $name = '';

    public string $description = '';

    public string $price = '';

    public string $age = '';

    public string $stock = '0';

    public ?int $category_id = null;

    public bool $is_featured = false;

    public bool $is_active = true;

    public string $image_url = '';

    /** @var array<int, array{id:int,url:string,color_name:string,color_hex:string}> */
    public array $gallery = [];

    /** @var array<int, mixed> */
    public $new_images = [];

    public string $search = '';

    public bool $showForm = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function toggleForm(): void
    {
        $this->showForm = ! $this->showForm;
    }

    public function edit(int $id): void
    {
        $this->showForm = true;

        $product = Product::with('images')->findOrFail($id);

        $this->editingId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description ?? '';
        $this->price = (string) $product->price;
        $this->age = $product->age ?? '';
        $this->stock = (string) $product->stock;
        $this->category_id = $product->category_id;
        $this->is_featured = $product->is_featured;
        $this->is_active = $product->is_active;
        $this->image_url = (is_string($product->image) && str_starts_with($product->image, 'http'))
            ? $product->image
            : '';
        $this->new_images = [];
        $this->loadGallery($product);
        $this->resetValidation();
    }

    public function setAsMain(int $index): void
    {
        if (! $this->editingId) {
            $this->dispatch('toast', message: 'Save the product first', type: 'warning');

            return;
        }

        $item = $this->gallery[$index] ?? null;

        if (! $item) {
            return;
        }

        $image = ProductImage::where('id', $item['id'])
            ->where('product_id', $this->editingId)
            ->first();

        if (! $image) {
            return;
        }

        Product::where('id', $this->editingId)->update(['image' => $image->path]);

        $this->loadGallery(Product::with('images')->findOrFail($this->editingId));

        $this->dispatch('toast', message: 'Main display image updated', type: 'success');
    }

    public function resetForm(): void
    {
        $this->reset([
            'editingId',
            'name',
            'description',
            'price',
            'age',
            'stock',
            'category_id',
            'is_featured',
            'image_url',
            'gallery',
            'new_images',
        ]);

        $this->is_active = true;
        $this->stock = '0';
        $this->showForm = false;
        $this->resetValidation();
    }

    public function removeGalleryImage(int $index): void
    {
        $item = $this->gallery[$index] ?? null;

        if (! $item) {
            return;
        }

        $image = ProductImage::find($item['id']);

        if ($image) {
            if (! str_starts_with($image->path, 'http')) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }

        unset($this->gallery[$index]);
        $this->gallery = array_values($this->gallery);

        if ($this->editingId) {
            $this->syncCoverImage(Product::find($this->editingId));
        }

        $this->dispatch('toast', message: 'Image removed', type: 'success');
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'description' => ['nullable', 'string', 'max:5000'],
            'price' => ['required', 'numeric', 'min:0'],
            'age' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'gallery.*.color_name' => ['nullable', 'string', 'max:50'],
            'gallery.*.color_hex' => ['nullable', 'string', 'max:20'],
            'new_images' => ['nullable', 'array'],
            'new_images.*' => ['nullable', 'image', 'max:4096'],
        ]);

        // Keep files before anything else clears them
        $uploads = collect($this->new_images ?? [])
            ->filter(fn ($file) => is_object($file) && method_exists($file, 'store'))
            ->values();

        $data = [
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description !== '' ? $this->description : null,
            'price' => $this->price,
            'age' => $this->age !== '' ? $this->age : null,
            'stock' => (int) $this->stock,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
        ];

        $isNew = ! $this->editingId;

        if ($this->editingId) {
            $product = Product::findOrFail($this->editingId);
            $product->update($data);
            $message = 'Product updated';
        } else {
            // Unique slug if name already exists
            $baseSlug = $data['slug'];
            $i = 1;
            while (Product::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $baseSlug.'-'.$i;
                $i++;
            }

            $product = Product::create($data);
            $message = 'Product added';
        }

        foreach ($this->gallery as $item) {
            ProductImage::where('id', $item['id'])
                ->where('product_id', $product->id)
                ->update([
                    'color_name' => ($item['color_name'] ?? '') !== '' ? $item['color_name'] : 'Color',
                    'color_hex' => ($item['color_hex'] ?? '') !== '' ? $item['color_hex'] : '#d5b08a',
                ]);
        }

        $defaults = ['#d92720', '#2f6fed', '#f5d76e', '#2d2a32', '#f7a8c5', '#a8e6cf'];
        $startIndex = $product->images()->count();
        $uploadedCount = 0;

        foreach ($uploads as $i => $file) {
            $path = $file->store('products', 'public');
            $order = $startIndex + $i;

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'color_name' => 'Color '.($order + 1),
                'color_hex' => $defaults[$order % count($defaults)],
                'sort_order' => $order,
            ]);

            $uploadedCount++;
        }

        // Cover: real URL, else first gallery image
        if ($this->image_url !== '' && str_starts_with($this->image_url, 'http')) {
            $product->update(['image' => $this->image_url]);
        } else {
            $this->syncCoverImage($product->fresh('images'));
        }

        $this->search = '';
        $this->new_images = [];
        $this->showForm = true;

        // Stay on edit so gallery + color fields show after save
        $this->edit($product->id);

        if ($uploadedCount > 0) {
            $message .= ' · '.$uploadedCount.' image(s) uploaded';
        }

        $this->dispatch('toast', message: $message, type: 'success');
    }

    public function delete(int $id): void
    {
        $product = Product::with('images')->findOrFail($id);

        foreach ($product->images as $image) {
            if (! str_starts_with($image->path, 'http')) {
                Storage::disk('public')->delete($image->path);
            }
        }

        if ($product->image && ! str_starts_with($product->image, 'http')) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        if ($this->editingId === $id) {
            $this->resetForm();
        }

        $this->dispatch('toast', message: 'Product deleted', type: 'success');
    }

    public function toggleActive(int $id): void
    {
        $product = Product::findOrFail($id);
        $product->update(['is_active' => ! $product->is_active]);

        $this->dispatch(
            'toast',
            message: $product->is_active ? 'Product activated' : 'Product deactivated',
            type: 'success'
        );
    }

    private function loadGallery(Product $product): void
    {
        $this->gallery = $product->images
            ->sortBy('sort_order')
            ->values()
            ->map(fn (ProductImage $image) => [
                'id' => $image->id,
                'url' => $image->url(),
                'path' => $image->path,
                'color_name' => $image->color_name ?: 'Color',
                'color_hex' => $image->color_hex ?: '#d5b08a',
                'is_main' => $product->image === $image->path,
            ])
            ->all();
    }

    private function syncCoverImage(?Product $product = null): void
    {
        if (! $product) {
            return;
        }

        $first = $product->images()->orderBy('sort_order')->orderBy('id')->first();

        if ($first) {
            $product->update(['image' => $first->path]);
        }
    }

    public function render()
    {
        $products = Product::with(['category', 'images'])
            ->when($this->search !== '', function ($query) {
                $term = '%'.$this->search.'%';
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', $term)
                        ->orWhere('slug', 'like', $term);
                });
            })
            ->latest()
            ->paginate(8);

        return view('livewire.admin.products', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
            'ages' => ['0-2 Years', '3-4 Years', '5-7 Years', '8-10 Years', '10+ Years'],
        ])->layout('layouts.admin', [
            'title' => 'Products',
        ]);
    }
}
