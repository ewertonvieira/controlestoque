<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('FAQ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Perguntas Frequentes') }}</h3>
                <div class="mt-4">
                    <div class="mb-4">
                        <h4 class="text-md font-semibold text-gray-700">{{ __('Como redefinir minha senha?') }}</h4>
                        <p class="text-gray-600">{{ __('Vá em "Perfil" > "Alterar Senha". Siga as instruções para criar uma nova senha.') }}</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-md font-semibold text-gray-700">{{ __('Como exportar dados para Excel?') }}</h4>
                        <p class="text-gray-600">{{ __('Acesse a tabela desejada e clique em "Exportar" no canto superior direito.') }}</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-md font-semibold text-gray-700">{{ __('Por que meu relatório aparece vazio?') }}</h4>
                        <p class="text-gray-600">{{ __('Verifique se os filtros de data ou categoria estão corretos antes de gerar.') }}</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-md font-semibold text-gray-700">{{ __('Posso cadastrar vários usuários?') }}</h4>
                        <p class="text-gray-600">{{ __('Sim! Vá em "Configurações" > "Usuários" para adicionar ou editar usuários.') }}</p>
                    </div>
                    <div class="mb-4">
                        <h4 class="text-md font-semibold text-gray-700">{{ __('O que significa a coluna "Status" na tabela X?') }}</h4>
                        <p class="text-gray-600">{{ __('A coluna indica se o item está ativo, inativo ou pendente de aprovação.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
