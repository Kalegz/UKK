<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('home') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                    {{ __('Home') }}
                </flux:navbar.item>
                <flux:navbar.item icon="shopping-bag" :href="route('posts')" :current="request()->routeIs('posts')" wire:navigate>
                    {{ __('Toko') }}
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <!-- @auth
                @if(auth()->user()->hasRole('Admin'))
                    <flux:navbar.item icon="user" :href="route('dash-admin')" wire:navigate>
                        {{ __('Admin Page') }}
                    </flux:navbar.item>
                @endif
                @if(auth()->user()->hasRole('Penjual'))
                    <flux:navbar.item icon="keranjang" :href="route('seller.index')" wire:navigate>
                        {{ __('Tambah dagangan') }}
                    </flux:navbar.item>
                @endif
            @endauth -->

            <!-- <flux:navbar class="mr-1.5 space-x-0.5 py-0!">
                <flux:tooltip :content="__('Search')" position="bottom">
                    <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass" href="#" :label="__('Search')" />
                </flux:tooltip>
                <flux:tooltip :content="__('Repository')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="folder-git-2"
                        href="https://github.com/laravel/livewire-starter-kit"
                        target="_blank"
                        :label="__('Repository')"
                    />
                </flux:tooltip>
                <flux:tooltip :content="__('Documentation')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="book-open-text"
                        href="https://laravel.com/docs/starter-kits"
                        target="_blank"
                        label="Documentation"
                    />
                </flux:tooltip>
            </flux:navbar> -->

            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                    <flux:dropdown position="top" align="end">
                        <flux:profile class="cursor-pointer" :initials="auth()->user()->initials()" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                            <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>

                                        <div class="grid flex-1 text-left text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            @auth
                                @if(auth()->user()->hasRole('Admin'))
                                    <flux:menu.radio.group>
                                        <flux:menu.item :href="route('dash-admin')" icon="user" wire:navigate>{{ __('Admin Page') }}</flux:menu.item>
                                    </flux:menu.radio.group>

                                    <flux:menu.separator />
                                @endif
                                @if(auth()->user()->hasRole('Penjual'))
                                    <flux:menu.radio.group>
                                        <flux:menu.item :href="route('seller.index')" icon="keranjang" wire:navigate>{{ __('Cek Dagangan') }}</flux:menu.item>
                                    </flux:menu.radio.group>

                                    <flux:menu.separator />
                                @endif
                            @endauth

                            <flux:menu.radio.group>
                                <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar stashable sticky class="hidden border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('home') }}" class="ml-1 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')">
                    <flux:navbar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        {{ __('Home') }}
                    </flux:navbar.item>
                    <flux:navbar.item icon="layout-grid" :href="route('posts')" :current="request()->routeIs('posts')" wire:navigate>
                        {{ __('Toko') }}
                    </flux:navbar.item>
                </flux:navlist.group>
            </flux:navlist>

            <!-- <flux:spacer /> -->

            <!-- <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist> -->
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
