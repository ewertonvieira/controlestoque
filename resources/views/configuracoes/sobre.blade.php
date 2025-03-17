<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sobre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <h3 class="text-lg font-medium text-gray-900">{{ __('Nome do Sistema') }}</h3>
                <p class="mt-2 text-gray-600">{{ __('Delta Estoque') }}</p>

                <h3 class="text-lg font-medium text-gray-900 mt-4">{{ __('Versão') }}</h3>
                <p class="mt-2 text-gray-600">{{ __('Versão 1.0.0 - Atualizado em 10/03/2025') }}</p>

                <h3 class="text-lg font-medium text-gray-900 mt-4">{{ __('Descrição') }}</h3>
                <p class="mt-2 text-gray-600">
                    {{ __('Sistema para controle de estoque, registro de entradas e saídas, geração de relatórios gerenciais e exportação de dados para Excel e arquivos de tipo CSV.') }}
                </p>

                <h3 class="text-lg font-medium text-gray-900 mt-4">{{ __('Quem desenvolveu') }}</h3>
                <p class="mt-2 text-gray-600">
                    {{ __('Desenvolvido por Ewerton Vieira') }} - 
                    <a href="https://github.com/ewertonvieira" target="_blank" class="text-blue-500 hover:underline">GitHub</a>
                </p>

                <h3 class="text-lg font-medium text-gray-900 mt-4">{{ __('Créditos') }}</h3>
                <p class="mt-2 text-gray-600">
                    {{ __('Este sistema foi desenvolvido utilizando os frameworks e bibliotecas:') }}
                </p>
                <ul class="list-disc list-inside mt-2 text-gray-600">
                    <li>Laravel 8.2</li>
                    <li>Jetstream + Tailwind CSS</li>
                    <li>Spreadsheet</li>
                </ul>

                <h3 class="text-lg font-medium text-gray-900 mt-4">{{ __('Política de Privacidade / Termos de Uso') }}</h3>
                <p class="mt-2 text-gray-600">
                    <a href="{{ route('politica.privacidade') }}" class="text-blue-500 hover:underline">{{ __('Política de Privacidade') }}</a> /
                    <a href="{{ route('termos.uso') }}" class="text-blue-500 hover:underline">{{ __('Termos de Uso') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
