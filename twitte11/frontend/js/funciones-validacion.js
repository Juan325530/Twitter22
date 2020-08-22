//Validar si un campo requerido en un formulario está vacío.
function validarCampoVacio(id){
    if(document.getElementById(id).value == ""){
        addInvalid(id);
        return false;
    } else {
        addValid(id);     
        return true;
    }
}
//Validar un campo que no es obligatorio en un formulario.
function validarCampoNoObligatorio(id){
    addValid(id);
    return true;
}
//Agregar la clase "valid" a un elemento y remover "invalid", indicando que está correcto.
function addValid(id) {
    document.getElementById(id).classList.remove("is-invalid");
    document.getElementById(id).classList.add("is-valid");    
}
//Agregar la clase "invalid" a un elemento y remover "valid", indicando que está incorrecto.
function addInvalid(id) {
        document.getElementById(id).classList.remove("is-valid");
        document.getElementById(id).classList.add("is-invalid");
}

//Validar que dos contraseñas coincidan entre si. En especial para un formulario de registro.
function confirmarContrasenas(contra1,contra2){
    let validarC1 = validarRegex(contra1, "password");
    let validarC2 = validarRegex(contra2, "password"); //Confirmar contraseña 
    if ( validarC1 && validarC2 ) {
        if (document.getElementById(contra1).value == document.getElementById(contra2).value) {
            addValid(contra1);
            addValid(contra2);
            return true;
        } else {
            addInvalid(contra1);
            addInvalid(contra2);
            alert("Las contraseñas no coinciden.");  
            return false;
        }
    } else {
        return false;
    }
}
/* ------ Validar campos usando expresiones regulares ------ */
//Validar mediante expresiones regulares el formato de números enteros y decimales, contraseñas, email y username.
function validarRegex(id, tipo) {
    var re = null;
    switch (tipo) {
        case "entero":
            re = /^[0-9]+$/;
            break;
        case "decimal":
            re = /^[0-9]*[,|\.]?[0-9]+$/;
            break;
        case "password":
            re = /^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[@!?$%:;\+\-_.,<>]).*$/;
            break;
        case "username":
            re = /^^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
            break;
        case "email":
            re = /^(([^<>()%&[\]\.,;:\s@\"]+(\.[^<>()%&[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()%&[\]\.,;:\s@\"]+\.)+[^<>()%&[\]\.,;:\s@\"]{2,})$/;
            break;
    }
    console.log(re);
    if ( re.test(document.getElementById(id).value) ) {
        console.log(tipo+" valido: " + document.getElementById(id).value);
        addValid(id);
        return true;
    } else {
        console.log(tipo+" invalido: " + document.getElementById(id).value);
        addInvalid(id);
        return false;
    }
}