{{-- use auto ident to unmerge lines --}}
@php
$appUrl = env('APP_URL');
$appName = env('APP_NAME');
$footerLink = 'adminpanelv3.com.br';
$logo = "logo.png";
$newPass = $data['pass'];
@endphp

<body style="margin: 0;padding: 20px;width: 96%; border-radius: 1.5rem;">


    <img style="
    margin: .5% auto; width: 8rem;
    max-width: 90%;" src="{!! asset($logo) !!}">

    <font size="3" face="ARIAL" color="#333">
        <h2 style="color: #0c1011;font-size: 26px;font-weight: 900;">

            Nova senha | {{ $appName }}
        </h2>
        <p>
            Olá {{$data['name']}}, você solicitou a recuperação da sua senha.
        </p>

        <p>
            Segue abaixo sua nova senha, utilize-a para acessar o
            aplicativo, no
            primeiro acesso será solicitado que altere essa senha
            para uma de sua
            escolha.
        </p>

        <p style="margin-top: 2rem">
            <b>Sua nova senha é:</b>
        </p>

        <div style="
                              text-align: center;
                              margin-top: 2rem;
                              width: 10rem;
                              background: #c3c3c3;
                              padding: 0.75rem;
                              border-radius: 50rem;
                              margin-left: auto;
                              margin-right: auto;
                              font-size: 1.5rem;
                              color: black !important
                          ">
            <b>
                <span style=" color:black; text-decoration: none; font-size: 20px">{{$newPass}}</span>
            </b>
        </div>

        <p style="margin-top: 2rem;">
            Atenciosamente, Equipe Admin Panel V3.
        </p>

    </font>






</body>
