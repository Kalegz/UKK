<x-layouts.app.sidebar :title="'Manage Users'">
    <flux:main>
        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="min-h-screen bg-white dark:bg-zinc-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="py-3">User ID</th>
                                    <th scope="col" class="py-3">Name</th>
                                    <th scope="col" class="py-3">Email</th>
                                    <th scope="col" class="py-3">Role</th>
                                    <th scope="col" class="py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->roles->pluck('name')->first() ?? 'No Role' }}</td>
                                        <td>
                                            <!-- Dropdown -->
                                            <flux:dropdown position="bottom" align="start">
                                                <flux:button icon="ellipsis-vertical" variant="subtle" />
                                                <flux:menu class="w-[50px] min-w-25">
                                                    <!-- Edit Button -->
                                                    <flux:menu.item 
                                                        icon="edit" 
                                                        class="text-gray-700" 
                                                        data-modal-target="editModal-{{ $user->id }}" 
                                                        data-modal-toggle="editModal-{{ $user->id }}"
                                                    >
                                                        {{ __('Edit') }}
                                                    </flux:menu.item>
                                                    <flux:menu.separator />
                                                    <!-- Delete Button -->
                                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <flux:menu.item 
                                                            icon="trash" 
                                                            class="text-gray-700"
                                                            as="button"
                                                        >
                                                            {{ __('Delete') }}
                                                        </flux:menu.item>
                                                    </form>
                                                </flux:menu>
                                            </flux:dropdown>

                                            <!-- Edit Modal -->
                                            <div id="editModal-{{ $user->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-zinc-900 bg-opacity-50">
                                                <div class="bg-white p-6 rounded-lg shadow-lg w-96 dark:bg-gray-800">
                                                    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Edit User</h2>
                                                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Name -->
                                                        <div class="mb-4">
                                                            <label for="name-{{ $user->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                                            <input 
                                                                type="text" 
                                                                id="name-{{ $user->id }}" 
                                                                name="name" 
                                                                value="{{ $user->name }}" 
                                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                                                required
                                                            />
                                                        </div>

                                                        <!-- Email -->
                                                        <div class="mb-4">
                                                            <label for="email-{{ $user->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                                            <input 
                                                                type="email" 
                                                                id="email-{{ $user->id }}" 
                                                                name="email" 
                                                                value="{{ $user->email }}" 
                                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                                                required
                                                            />
                                                        </div>

                                                        <!-- Role -->
                                                        <div class="mb-4">
                                                            <label for="role-{{ $user->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                                            <select 
                                                                id="role-{{ $user->id }}" 
                                                                name="role" 
                                                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                                            >
                                                                @foreach($roles as $role)
                                                                    <option value="{{ $role->name }}" @if($user->roles->pluck('name')->first() == $role->name) selected @endif>
                                                                        {{ $role->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Submit -->
                                                        <div class="flex justify-end">
                                                            <button type="submit" class="px-4 py-2 bg-primary-700 text-white rounded-md hover:bg-primary-800">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </flux:main>

    <!-- JavaScript for Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalToggles = document.querySelectorAll('[data-modal-toggle]');
            modalToggles.forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const modalId = toggle.getAttribute('data-modal-toggle');
                    const modal = document.getElementById(modalId);
                    modal.classList.toggle('hidden');
                });
            });
        });
    </script>
</x-layouts.app.sidebar>
