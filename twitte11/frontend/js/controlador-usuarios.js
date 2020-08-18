const urlUsuarios = '../backend/api/usuarios.php';

// Lista de usuarios
function obtenerUsuarios(){
    axios({
        method: 'GET',
        url:urlUsuarios,
        responseType:'json'
    }).then(res=>{
        console.log(res);
    }).catch(error=>{
        console.error(error);
    });
}
obtenerUsuarios();

// Registrar un nuevo usuario, guardarlo en archivo, crear sesion
function guardarUsuario(){
    document.getElementById("iniciar2").disabled = true;
    let validacionNombre = validarCampoVacio("nombre");
    let validacionApellido = validarCampoVacio("apellido");
    let validacionCorreo = validarRegex("correo", "email");
    let validacionfechaNacimiento = validarCampoVacio("fechaNacimiento");
    let validacionContrasenas = confirmarContrasenas("contrasena1", "contrasena2");
    if (validacionNombre && validacionApellido && validacionCorreo && validacionfechaNacimiento && validacionContrasenas) {
        let usuario ={
            nombre: document.getElementById('nombre').value,
            apellido: document.getElementById('apellido').value,
            correo: document.getElementById('correo').value,
            fechaNacimiento: document.getElementById('fechaNacimiento').value,
            contrasena: document.getElementById('contrasena1').value
        };
        console.log('Usuario', usuario);
        axios({
            method: 'POST',
            url: urlUsuarios,
            responseType:'json',
            data:usuario
    
        }).then(res=>{
            console.log(res);
            if (res.data == 1) {
                window.location = "home.html";
                document.getElementById("iniciar2").disabled = false;
            } else {
                document.getElementById("feedbackCorreoInvalido").innerHTML = "Este correo ya está en uso.";
                addInvalid("correo");
                document.getElementById("iniciar2").disabled = false;
            }
            obtenerUsuarios();
    
        }).catch(error=>{
            console.error(error);
            document.getElementById("iniciar2").disabled = false;
        });
    } else {
        if (validacionCorreo == false) {
            document.getElementById("feedbackCorreoInvalido").innerHTML = "Campo inválido.";
        }
            document.getElementById("iniciar2").disabled = false;
    }
}

// Iniciar sesion, validar credenciales, crear sesion
function iniciarSesion(){
    document.getElementById("iniciar").disabled = true; //inabilito el boton
    let validacionCorreo = validarRegex("correo", "email"); //validacion 
    let validacionContrasena = validarCampoVacio("contrasena");
    if (validacionCorreo && validacionContrasena) {
        let parametrosUsuario = "correo="+document.getElementById("correo").value+"&"+
                                "contrasena="+document.getElementById("contrasena").value;
        axios({
            method: 'GET',
            url:urlUsuarios+"?"+parametrosUsuario,
            responseType:'json'
        }).then(res=>{
            console.log(res);
            switch (res.data) {
                case 1:  //correcto 
                    addValid("correo");
                    addValid("contrasena");
                    window.location = "home.html";
                    document.getElementById("iniciar").disabled = false;
                    break;
                case 0:  //incorrecto
                    addInvalid("correo");
                    addInvalid("contrasena");
                    document.getElementById("iniciar").disabled = false; 
                    break;
            }
        }).catch(error=>{
            console.error(error);
            document.getElementById("iniciar").disabled = false;
        });
        // document.getElementById("iniciar").disabled = false;
    } else {
        document.getElementById("iniciar").disabled = false;
    }
}