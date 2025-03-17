<x-layouts.app title="Posts">
  <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4">
      @if ($posts->isEmpty())
          <p class="text-gray-500 text-center">Belum ada post yang dibuat.</p>
      @else
          @foreach ($posts as $post)
              <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded shadow">
                  <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                      {{ $post->title }}
                  </h3>
                  <p class="text-gray-700 dark:text-gray-300">
                      {{ $post->content }}
                  </p>
                  <p class="text-gray-500 dark:text-gray-400">
                      Stok: {{ $post->stock }}
                  </p>
                  <small class="text-gray-500 dark:text-gray-400">
                      Diposting oleh: {{ $post->user->name }} pada {{ $post->created_at->format('d M Y, H:i') }}
                  </small>
              </div>
          @endforeach
      @endif
  </div>
</x-layouts.app>
