<x-layouts.app.sidebar-seller :title="'Manage Posts'">
    <flux:main>
        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="min-h-screen bg-white dark:bg-zinc-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <!-- Tombol untuk Menambah Post -->
                    <div class="p-4 flex justify-end">
                        <button 
                            type="button" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" 
                            data-modal-target="addPostModal"
                            data-modal-toggle="addPostModal">
                            Tambah Post
                        </button>
                    </div>

                    <!-- Kontainer Posts -->
                    <div class="overflow-x-auto p-4">
                        @if ($posts->isEmpty())
                            <p class="text-white text-center">Belum ada post yang ditambahkan.</p>
                        @else
                            @foreach ($posts as $post)
                                <div class="mb-4 p-4 bg-gray-200 dark:bg-gray-700 rounded shadow">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $post->title }}</h3>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $post->content }}</p>
                                    @if ($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Image for {{ $post->title }}" class="mt-2 max-h-48 rounded">
                                    @endif
                                    <!-- Menampilkan stok -->
                                    <p class="mt-2 text-gray-700 dark:text-gray-300">Stok: {{ $post->stock }}</p>
                                    <small class="text-gray-500 dark:text-gray-400">
                                        Diposting pada: {{ $post->created_at->format('d M Y, H:i') }}
                                    </small>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Modal Form untuk Menambah Post -->
        <div id="addPostModal" tabindex="-1" aria-hidden="true" 
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg max-w-md w-full">
                <div class="p-4 border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Tambah Post Baru
                    </h3>
                </div>
                <form action="{{ route('seller.create') }}" method="POST" enctype="multipart/form-data" class="p-4">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Judul
                        </label>
                        <input type="text" id="title" name="title" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Deskripsi
                        </label>
                        <textarea id="content" name="content" rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Gambar (opsional)
                        </label>
                        <input type="file" id="image" name="image" 
                            class="mt-1 block w-full text-gray-900 dark:text-gray-300 rounded-md border-gray-300 dark:border-gray-600 shadow-sm sm:text-sm">
                    </div>
                    <!-- Field untuk mengatur stok -->
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Stok
                        </label>
                        <input type="number" id="stock" name="stock" min="0" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" 
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded" 
                            data-modal-hide="addPostModal">
                            Batal
                        </button>
                        <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar-seller>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('addPostModal');
        const openModalButton = document.querySelector('[data-modal-target="addPostModal"]');
        const closeModalButtons = document.querySelectorAll('[data-modal-hide="addPostModal"]');

        // Fungsi untuk membuka modal
        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        // Fungsi untuk menutup modal
        closeModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            });
        });

        // Menutup modal jika area di luar modal diklik
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        });
    });
</script>
