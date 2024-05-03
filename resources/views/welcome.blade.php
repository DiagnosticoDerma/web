<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
    content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>ChatBot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="https://demo.adminkit.io/tables-datatables-buttons.html" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" />
    <link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <link rel="canonical" href="https://demo.adminkit.io/tables-datatables-responsive.html" />
    <link rel="canonical" href="https://demo.adminkit.io/tables-datatables-buttons.html" />
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style type="text/css">
        .container-fluid>.d-flex>div{
            width: 50%;
        }
        .img-portada{
            width: 100%;
            height: 100vh;
            object-fit: cover;
        }
        .chatbot{
            height: 100vh;
        }
        .chatbot>.card{
            margin: 0;
            height: 100vh;
        }
        .chat-messages{
            min-height: 86vh;
        }
        body{
            overflow-y: unset;
        }
        .card>.py-2.px-4.border-bottom{
            height: 7vh;
        }
        .card>.flex-grow-0.py-3.px-4.border-top{
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 7vh;
        }
        @media (max-width: 990px){
            .container-fluid>.d-flex>div{
                width: 100%;
            }
        }
        .rounded{
            border-radius: 1rem !important;
        }
        iframe{
            width: 100%;
            height: 185px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="main">

            <div class="container-fluid p-0">
                <div class="d-flex">
                    <div class="d-none d-md-block">
                        <img src="{{ asset('assets/img/login.jpg') }}" class="img-portada">
                    </div>
                    <div class="chatbot">
                        <div class="card">
                            <div class="py-2 px-4 border-bottom">
                                <div class="d-flex align-items-center py-1">
                                    <div class="position-relative">
                                        <img src="{{ asset('assets/img/logo.png') }}" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
                                    </div>
                                    <div class="flex-grow-1 ps-3">
                                        <strong>ChatBot</strong>
                                        <div class="text-muted small d-none" id="loading"><em>Escribiendo...</em></div>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary btn-lg me-1 px-3 refresh"><i class="feather-lg" data-feather="refresh-cw"></i></button>
                                        <!-- <button class="btn btn-info btn-lg me-1 px-3 d-none d-md-inline-block"><i class="feather-lg" data-feather="video"></i></button>
                                        <button class="btn btn-light border btn-lg px-3"><i class="feather-lg" data-feather="more-horizontal"></i></button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="position-relative">
                                <div class="chat-messages p-4">
                                    <div class="chat-message-left pb-4">
                                        <div>
                                            <img src="{{ asset('assets/img/logo.png') }}" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
                                            <!-- <div class="text-muted small text-nowrap mt-2">{{ date('h:i a',strtotime(date('H:i:s'))) }}</div> -->
                                        </div>
                                        <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
                                            Ingrese por favor su número de DNI
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-grow-0 py-3 px-4 border-top">
                                <form id="form-chat">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="input-message" placeholder="Escribe tu mensaje" autocomplete="off">
                                        <button class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="loading-screen" style="display:none;">
        <img src="{{ asset('assets/icon/spinning-circles.svg') }}">
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.js') }}"></script>
    <!-- `Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <!-- Validaror js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var start = 1;
        var id_componente;
        var id_componente_pregunta;
        var id_area;

        $("#form-chat").submit(function(e) {
            e.preventDefault();
            var input = $("#input-message").val();
            if(input){
                setUser(input);
                if(start == 1){           
                    loading("show");
                    $.post("{{ route('chatbot.dni') }}", {input: input}, function(res) {
                        loading("hide");
                        if(res.result){
                            setBot(res.message);
                            start=2;
                            id_area = res.data.id_area;
                            setBot("Por favor ingrese el codigo de su terminal");
                            $("#input-message").focus();
                        }else{
                            setBot(res.message);
                        }
                    });
                }else if(start == 2){
                    consultarTerminal(input);
                }else if(start == 3){
                    $.post("{{ URL::to('/chatbot/validarPregunta') }}" + "/" + id_componente_pregunta,{ input: input}, function(res) {
                        if(res.result){
                            start=null;
                            setComponente();                            
                        }else{
                            setBot(res.message);
                        }
                    });
                }
            }
        });

        function consultarTerminal(input)
        {
            console.log(input);
            $.post("{{ route('chatbot.terminal') }}", {input: input,id_area}, function(res) {
                loading("hide");
                if(res.result){
                    setBot(res.message);
                    id_componente = res.data.id;
                    setComponente();
                    start=null;
                }else{
                    setBot(res.message);
                }
            });
        }

        function setComponente()
        {
            loading("show");
            $.get("{{ URL::to('/chatbot/setComponente') }}" + "/" + id_componente, function(res) {
                loading("hide");
                setBot(res.data.componente.mensaje);
                if(res.data.componente.tipo_respuesta == 2){
                    var iframe = `<iframe src="https://www.youtube.com/embed/${res.data.componente.respuesta}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
                    setIframe(iframe);
                }else if(res.data.componente.tipo_respuesta == 3){
                    var url = "{{ URL::to('/') }}" + "/" + res.data.componente.respuesta;
                    var file = `<a href="${url}" download>${iconDownload()} Descargar archivo</a>`;
                    setBot(file);
                }

                if(res.data.componente.tipo == 1){
                    var data="";
                    $.each(res.data.opciones, function(index, val) {
                        data += `<button class="btn btn-pill btn-primary" onclick="setOpcion(${val.id})">${val.nombre}</button> `;
                    });
                    setBotMultiple(data);
                    $("#input-message").attr("disabled",true);
                }else{
                    if(res.data.componente.tipo == 0){
                        id_componente = res.data.componente.id_componente;
                        $("#input-message").attr("disabled",true);
                    }else if(res.data.componente.tipo == 2){
                        id_componente = res.data.componente.id_componente;
                        if(res.data.componente.id != 0){
                            setComponente();
                        }else{
                            $("#input-message").attr("disabled",true);
                        }
                    }else if(res.data.componente.tipo == 3){
                        id_componente_pregunta = id_componente;
                        id_componente = res.data.componente.id_componente;
                        $("#input-message").attr("disabled",false);
                        start = 3;
                    }
                }
            });
        }

        function setBot(input)
        {
            var message = `<div class="chat-message-left pb-4">
            <div>
            <img src="{{ asset('assets/img/logo.png') }}" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
            </div>
            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
            ${input}
            </div>
            </div>`;
            $('.chat-messages').append(message);
            $("#input-message").val("");
        }

        function setIframe(input)
        {
            var message = `<div class="chat-message-left pb-4">
            <div>
            <img src="{{ asset('assets/img/logo.png') }}" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
            </div>
            <div class="py-2 ms-3">
            ${input}
            </div>
            </div>`;
            $('.chat-messages').append(message);
            $("#input-message").val("");
        }

        function setBotMultiple(input)
        {
            var message = `<div class="chat-message-left pb-4 cp-${id_componente}">
            <div>
            <img src="{{ asset('assets/img/logo.png') }}" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
            </div>
            <div class="py-2 px-3">
            ${input}
            </div>
            </div>`;
            $('.chat-messages').append(message);
            $("#input-message").val("");
        }

        function setUser(input)
        {
            var message = `<div class="chat-message-right mb-4">
            <div>
            <img src="{{ asset('assets/img/avatar.png') }}" class="rounded-circle me-1" alt="Chris Wood" width="40" height="40">
            </div>
            <div class="flex-shrink-1 bg-primary rounded py-2 px-3 me-3">
            ${input}
            </div>
            </div>`;
            $('.chat-messages').append(message);
            $("#input-message").val("");
        }

        function loading(type)
        {
            if(type == "show"){
                $("#loading").removeClass('d-none');
                $("#loading").addClass('d-block');
            }else if(type == "hide"){
                $("#loading").removeClass('d-block');
                $("#loading").addClass('d-none');
            }
        }

        $(".refresh").click(function() {
            var message = `<div class="chat-message-left pb-4">
            <div>
            <img src="{{ asset('assets/img/logo.png') }}" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
            </div>
            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
            Ingrese por favor su número de DNI
            </div>
            </div>`;
            $('.chat-messages').html(message);
            $("#input-message").attr("disabled",false);
            start=1;
            id_componente_pregunta = null;            
        });

        function setOpcion(id)
        {
            $(`.cp-${id_componente}`).remove();
            $.get("{{ URL::to('/chatbot/setOpcion') }}" + "/" + id, function(res) {
                setUser(res.data.opcion.nombre);
                id_componente = res.data.componente.id;
                setComponente();
            });
        }

        function iconDownload()
        {
            return `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download align-middle"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>`;
        }
    </script>
</body>

</html>