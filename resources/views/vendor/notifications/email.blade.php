<x-mail::message>
# Olá!

Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.

<x-mail::button :url="$actionUrl" color="primary">
Redefinir Senha
</x-mail::button>

Este link de redefinição de senha expirará em 60 minutos.

Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.

Atenciosamente,<br>
{{ config('app.name') }}

<x-slot:subcopy>
Se você estiver com problemas para clicar no botão "Redefinir Senha", copie e cole o URL abaixo no seu navegador:
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
</x-mail::message>