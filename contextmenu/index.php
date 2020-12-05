<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="Gestor de achivos para linux" content="" />
        <meta name="los ñeros" content="" />
        <title>Gestor de archivos</title>

        <link rel="stylesheet" href="contextmenu/jquery.contextMenu.min.css">

        <script src="jquery-3.3.1.js"></script>
        <script src="contextmenu/jquery.contextMenu.js"></script>
        <script src="contextmenu/jquery.ui.position.min.js"></script>
        <link rel="stylesheet" href="bootstrap.min.css">
        <script type="text/javascript" src="bootstrap.min.js"></script>

        <link href="css/styles.css" rel="stylesheet" />

        <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->


    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top"> <img src="assets/img/logo.png"  <title aria-expanded="Gestor">Gestor de archivos</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ml-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ml-auto">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" id="button_atras">Atras</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" id="button_crear">Crear Carpeta</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" id="button_crear_archivo">Crear archivo</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" id="button_pegar">Pegar</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">

            <div class="container">
                <div class="masthead-subheading">Bienvenido al gestor de archivos linux</div>

            </div>
            <div> </div>
            <div id = "principal" class="grid-container">
            </div>
        </header>

    </body>

</html>

<div class="alert alert-dark" role="alert" id=text_alert>
    <button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
    <strong></strong>
</div>

<script type="text/javascript">$('#text_alert').hide();</script>

<script>


</script>

<div id="cambiar_nombre" class="modal">

    <form class="modal-content animate">

        <div class="container">
            <label for="uname" id = 'title_name'></label>
            <input type="text" name="new_name" id = "new_name" required>
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="old_name" id = "old_name" />
            <button type="button" name="accept_change_name" id = "accept_change_name" class = "Acceptbtn">Aceptar</button>
            <button type="button" onclick="document.getElementById('cambiar_nombre').style.display='none'" class="cancelbtn">Cancelar</button>
        </div>

    </form>
</div>

<div id = "permisos" class="modal">
    <form class="modal-content animate">
        <div class="container">
            <label>Propietario</label>
            <label for="checkbox1">R</label>
            <input type="checkbox" name="checkbox" id="Rpropietario">
            <label for="checkbox2">W</label>
            <input type="checkbox" name="checkbox" id="Wpropietario">
            <label for="checkbox3">X</label>
            <input type="checkbox" name="checkbox" id="Xpropietario"><br>
            <label>Grupo</label>
            <label for="checkbox1">R</label>
            <input type="checkbox" name="checkbox" id="Rgrupo">
            <label for="checkbox2">W</label>
            <input type="checkbox" name="checkbox" id="Wgrupo">
            <label for="checkbox3">X</label>
            <input type="checkbox" name="checkbox" id="Xgrupo"><br>
            <label>Otros</label>
            <label for="checkbox1">R</label>
            <input type="checkbox" name="checkbox" id="Rotros">
            <label for="checkbox2">W</label>
            <input type="checkbox" name="checkbox" id="Wotros">
            <label for="checkbox2">X</label>
            <input type="checkbox" name="checkbox" id="Xotros">
            <input type="hidden" name="name_permisos" id="name_permisos"/>
            <button type="button" id="button_permisos" class="Acceptbtn">Aceptar</button>
            <button type="button" onclick="document.getElementById('permisos').style.display='none'" class="cancelbtn">Cancelar</button>
        </div>
    </form>
</div>

<?php
session_start();
?>

<script>
    $(document).ready(function(){

        load_folder_list();

        $(function() {
            $.contextMenu({
                selector: '.grid-item',

                items: {
                    "list":{name:"--> Abrir",callback:function(key,opt){view_files($(this).text());}},
                    "cut": {name: "--> Cortar",callback:function(key,opt){copiar($(this).text(),false);}},
                    "copy": {name: "--> Copiar",callback:function(key,opt){copiar($(this).text(),true);}},
                    "cambiar_permisos": {name: "--> Cambiar Permisos",callback:function(key,opt){permisos($(this).text());}},
                    "change_name":{name: "--> Cambiar Nombre",callback:function(key,opt){cambiar_nombre($(this).text());}},
                    "delete": {name: "--> Borrar",callback:function(key,opt){delete_($(this).text());}}
                }
            });
        });



        function call_alerts(text){
            $("#text_alert").text(text);
            $(".alert").show();
            setTimeout(function(){
                $(".alert").hide();
            },5000);
        }

        function load_folder_list()
        {
            var action = "fetch";
            $.ajax({
                url:"script.php",
                method:"POST",
                data:{action:action},
                success:function(data)
                {
                    $('#principal').html(data);
                    $('#adress_bar').text($('#dir').val());

                }
            });
        }

        function view_files(folder_name = "<?php $_SESSION['ruta']; ?>"){
            var action = "fetch_files";
            $.ajax({
                url : "script.php",
                method: "POST",
                data:{action:action, folder_name:folder_name},
                success:function(data)
                {
                    if(data.trim() == "no"){
                        call_alerts("no es una carpeta");
                        view_files();
                    }
                    else{
                        $('#principal').html(data);
                    }
                }
            });
        }

        function delete_(folder_name){
            var action = "delete";
            if(confirm("esta seguro de borrar "+folder_name))
            {
                $.ajax({
                    url:"script.php",
                    method:"POST",
                    data:{action:action,folder_name:folder_name},
                    success:function(data)
                    {
                        view_files();
                        call_alerts(data);

                    }
                });
            }
        }

        function permisos(name){
            var action = "consultar_permisos";
            $('#name_permisos').val(name);
            $.ajax({
                url:"script.php",
                method:"POST",
                data:{action:action,consulta:name},
                success:function(data)
                {
                    var ids = ['Rpropietario','Wpropietario','Xpropietario','Rgrupo',
                        'Wgrupo','Xgrupo','Rotros','Wotros','Xotros'];
                    var bool = false;
                    ids.forEach(function(valor,indice,array){
                        bool =data[indice+3] != '-' ? true:false;
                        $('#'+valor).prop('checked',bool);
                        document.getElementById("permisos").style.display='block';
                    });


                }
            });

        }

        function cambiar_nombre(old_name){
            var name = old_name.trim();
            $('#title_name').text("Cambiar Nombre");
            $('#old_name').val(name);
            $('#new_name').val(name);
            $('#action').val("change");
            document.getElementById('cambiar_nombre').style.display= 'block';

        }

        $(document).on('click','#button_crear',function(){
            $('#new_name').val('');
            $('#title_name').text("Crear carpeta");
            $('#action').val("create");
            document.getElementById('cambiar_nombre').style.display= 'block';
        });


        $(document).on('click','#button_crear_archivo',function(){
            $('#new_name').val('');
            $('#title_name').text("Crear archivo");
            $('#action').val("create_file");
            document.getElementById('cambiar_nombre').style.display= 'block';
        });


        function copiar(name,bool){
            var action = "copiar";
            $.ajax({
                url : "script.php",
                method: "POST",
                data:{action:action, copy_name:name,bool:bool},
                success:function(data)
                {
                }
            });
        }


        $(document).on('click', '#accept_change_name', function(){
            var new_name = $('#new_name').val();
            var old_name = $('#old_name').val();
            var action = $('#action').val();
            if(new_name !== '')
            {
                $.ajax({
                    url:"script.php",
                    method:"POST",
                    data:{new_name:new_name, old_name:old_name, action:action},
                    success:function(data)
                    {
                        document.getElementById('cambiar_nombre').style.display= 'none';
                        view_files();
                        call_alerts(data);
                    }
                });
            }
            else
            {
                alert("Enter Folder Name");
            }
        });

        $(document).on('click','#button_atras',function(){
            var action = "back";
            $.ajax({
                url : "script.php",
                method: "POST",
                data:{action:action},
                success:function(data)
                {
                    call_alerts(data);
                    view_files();

                }
            });
        });


        $(document).on('click','#button_permisos',function(){
            var ids = ['Rpropietario','Wpropietario','Xpropietario','Rgrupo',
                'Wgrupo','Xgrupo','Rotros','Wotros','Xotros'];
            var result = '';
            suma = 0;
            if($('#'+ids[0]).prop('checked')){
                suma += 4;
            }
            if($('#'+ids[1]).prop('checked')){
                suma += 2;
            }
            if($('#'+ids[2]).prop('checked')){
                suma += 1;
            }
            result += suma;
            suma = 0;
            if($('#'+ids[3]).prop('checked')){
                suma += 4;
            }
            if($('#'+ids[4]).prop('checked')){
                suma += 2;
            }
            if($('#'+ids[5]).prop('checked')){
                suma += 1;
            }
            result += suma;
            suma = 0;
            if($('#'+ids[6]).prop('checked')){
                suma += 4;
            }
            if($('#'+ids[7]).prop('checked')){
                suma += 2;
            }
            if($('#'+ids[8]).prop('checked')){
                suma += 1;
            }
            result += suma;
            var action = "editar_permisos";
            var name_permisos = $('#name_permisos').val();
            $.ajax({
                url: "script.php",
                method: "POST",
                data: {action:action,permisos:result,name:name_permisos},
                success:function(data){
                    document.getElementById('permisos').style.display= 'none';
                    call_alerts(data);

                }
            });

        });

        $(document).on('click','#button_pegar',function(){
            var action = "pegar";
            $.ajax({
                url: "script.php",
                method: "POST",
                data:{action:action},
                success:function(data){
                    view_files();
                    call_alerts(data);
                }
            });
        });



    });
</script>

<style>
    .grid-container {
        display: grid;
        grid-template-columns: auto auto auto;
        background-color: white;
        padding: 10px;
    }
    .grid-item {
        background-color: #e6e6e6;
        opacity: 0.9;
        border: 1px solid rgba(0, 0, 0, 0.4);
        padding: 20px;
        font-size: 30px;
        text-align: center;
        color: #846d1c;
    }
    .grid-item:hover{
        opacity: 1;
    }

    *{
        padding: 0;
        margin: 0;
    }
    *, *::before, *::after {
        box-sizing: inherit;
    }
    html{
        font-size: 16px;
        font-family: sans-serif;
        line-height: 1.5;
        -moz-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
        text-size-adjust: 100%;
        box-sizing: border-box;
    }
    body{
        padding: 1rem;
    }
    h1, h2, p, div{
        padding: 1rem 2rem;
    }

    body {font-family: Arial, Helvetica, sans-serif;}

    input[type=text] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    button:hover {
        opacity: 0.8;
    }

    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
        margin: auto;
    }
    .Acceptbtn{
        width: auto;
        padding: 10px 18px;
        margin: auto;
    }

    .container {
        padding: 16px;
    }


    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto 15% auto;
        border: 1px solid #888;
        width: 25%;
    }

    .animate {
        -webkit-animation: animatezoom 0.6s;
        animation: animatezoom 0.6s
    }

    @-webkit-keyframes animatezoom {
        from {-webkit-transform: scale(0)}
        to {-webkit-transform: scale(1)}
    }

    @keyframes animatezoom {
        from {transform: scale(0)}
        to {transform: scale(1)}
    }

    .boton_pegar
    {
        height:30px;
        width:150px;
        border-radius:6px;
        border: 2px solid #818181;
        padding:10px;
        font-size:20px;
        height:52px;
        cursor:pointer;
        background:transparent;
    }

    .boton_pegar:hover{
        opacity: 0.8;
        background-color: #bababa;
        color: white;
    }

    .content-box-testshadow{

        grid-column: 1/4;
        margin: 15px 15px 15px 15px;
        text-align: left;
        width: 95%;
        height: 50px;
        font-size: 20px;
        background-color: #f0f8ff;
        -moz-box-shadow: 0px 0px 20px #000000;
        -webkit-box-shadow: 0px 0px 20px #000000;
        box-shadow: 0px 0px 20px #000000;
    }
    #text_alert{
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        opacity: 0.6;
    }

</style>