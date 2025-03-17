<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Suporte') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Formulário de Contato') }}</h3>
                <form class="mt-4 space-y-4">
                    <div>
                        <x-label for="name" :value="__('Nome')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
                    </div>
                    <div>
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                    </div>
                    <div>
                        <x-label for="subject" :value="__('Assunto')" />
                        <x-input id="subject" class="block mt-1 w-full" type="text" name="subject" required />
                    </div>
                    <div>
                        <x-label for="description" :value="__('Descrição do problema')" />
                        <textarea id="description" class="block mt-1 w-full" name="description" rows="4" required></textarea>
                    </div>
                    <div>
                        <x-label for="attachment" :value="__('Anexar print/tela (opcional)')" />
                        <x-input id="attachment" class="block mt-1 w-full" type="file" name="attachment" />
                    </div>
                    <div>
                        <x-button>
                            {{ __('Enviar') }}
                        </x-button>
                    </div>
                </form>

                <h3 class="text-lg font-medium text-gray-900 mt-8">{{ __('Informações de Contato Direto') }}</h3>
                <p class="mt-2 text-gray-600">{{ __('Email de suporte: ewertonvieira2401@gmail.com') }}</p>
                <p class="mt-2 text-gray-600">{{ __('WhatsApp: (00) 90000-0000') }}</p>
                <p class="mt-2 text-gray-600">{{ __('Telefone: (00) 4002-8922') }}</p>
                <p class="mt-2 text-gray-600">{{ __('Horário de atendimento: Segunda a Sexta, das 9h às 17h') }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
