<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Currency --}}
    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="p-5 pt-3" />

            {{-- User --}}
            @if($user = auth()->user())
                <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                    class="!-my-2 rounded bg-opacity-10 bg-slate-500/50">
                    <x-slot:actions>
                        <x-button icon="o-power" class="text-error btn-circle btn-ghost btn-xs" tooltip-left="salir"
                            no-wire-navigate link="/logout" />
                    </x-slot:actions>
                </x-list-item>
            @endif
            {{-- MENU --}}
            <x-menu activate-by-route>
                <x-menu-item title="Inicio" icon="o-sparkles" link="/" />
                <x-menu-item title="Equipos" icon="o-user-group" link="/teams" />
                <x-menu-item title="Especies" icon="o-cube-transparent" link="/species" />

                <x-menu-sub title="Pagos" icon="o-currency-dollar">
                    <x-menu-item title="Generar Deuda" icon="o-banknotes" link="/debts" />
                    <x-menu-item title="Listados" icon="o-clipboard-document-list" link="####" />
                </x-menu-sub>
                <x-menu-item title="Email" icon="o-envelope" link="https://server.dns-principal-29.com:2096" external />
                <x-menu-item title="Equipos y Piezas" icon="o-printer" link="/reportTeamsFish" external />
                <x-menu-item title="Listado de Equipos por HP" icon="o-printer" link="/reportTeamsHP" external />
                <x-menu-item title="Listado de Deuda" icon="o-printer" link="/reportTeamsDebts" external />
                <x-menu-sub title="Settings" icon="o-cog-6-tooth">
                    {{-- <x-menu-item title="Wifi" icon="o-wifi" link="####" /> --}}
                    {{-- <x-menu-item title="Archives" icon="o-archive-box" link="####" /> --}}
                    <x-theme-toggle class="btn btn-circle btn-ghost" />
                </x-menu-sub>

                <x-menu-item title="CAPTURAS" icon="o-arrows-pointing-in" link="/captures" />
            </x-menu>

        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- TOAST area --}}
    <x-toast />
    {{-- Theme toggle --}}
    <x-theme-toggle class="hidden" />
</body>

</html>