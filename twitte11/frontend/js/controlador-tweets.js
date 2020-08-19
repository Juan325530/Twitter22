const urlTweets = '../backend/api/twits.php';

function generarTwits(){
    axios({
        method: 'get',
        url: urlTweets,
        responseType:'json',
    }).then(res=>{
        console.log(res.data);
        
        let twit = res.data; //guardo los twits originales 
        let comparar = res.data;  // comparar para obtener los datos del autor orginal 
        for (let i = 0; i < twit.length; i++) {  //si es diferente de cero es un retwit 
            if (twit[i].codigoTwitOriginal == 0) { // Si no fue retwiteado (fue escrito por el propio usuario) retwitear este tweet
                document.getElementById('twits').innerHTML +=
                `<div class="text-white card mb-2 bg-tweet">
                    <div class="card-header">
                        <img src="img/goku.jpg" class="rounded-circle mr-2" style="max-width: 3em;">
                        <a class="text-white" href="profile.php?idusuario=${twit[i].codigoUsuario}">${twit[i].nombreUsuario} ${twit[i].apellidoUsuario}</a>
                    </div>
                    <div class="card-body">
                        <div>${twit[i].contenidoTwit}</div>
                    </div>
                    <div class="card-footer">
                        <button class="link-style" type="button" onclick="compartirTweet('${twit[i].contenidoTwit}', '${twit[i].codigoTwit}');">
                            <i class="fas fa-share mr-2" aria-hidden="true"></i>
                            <span>${twit[i].cantidadReTwits} Retweets</span>
                        </button>
                        <button class="link-style" type="button" onclick="modaleditartweet('${twit[i].codigoTwit}');">
                        <i class="fas fa-edit mr-2" aria-hidden="true"></i>
                        <span>Editar Tweet</span>
                    </button>
                    </div>
                </div>`;
            } else { // Si la publicacion fue retwiteada (alguien mas lo escribio), entonces compartir ese tweet
                for (let j = 0; j < comparar.length; j++) {
                    if (twit[i].codigoTwitOriginal == comparar[j].codigoTwit) {
                        document.getElementById('twits').innerHTML +=
                        `<div class="text-white card mb-2 bg-tweet">
                            <div class="card-header">
                                <img src="img/goku.jpg" class="rounded-circle mr-2" style="max-width: 3em;">
                                <a class="text-white" href="profile.html?idusuario=${twit[i].codigoUsuario}">${twit[i].nombreUsuario} ${twit[i].apellidoUsuario}</a>
                            </div>
                            <div class="card-body">
                                <i>Retwitteado de <a href="profile.php?idusuario=${comparar[j].codigoUsuario}">«${comparar[j].nombreUsuario} ${comparar[j].apellidoUsuario}»</a></i>
                                <div>${twit[i].contenidoTwit}</div>
                                <button class="link-style" type="button" onclick="compartirTweet('${twit[i].contenidoTwit}', '${twit[i].codigoTwitOriginal}');">
                                    <i class="fas fa-share mr-2" aria-hidden="true"></i>
                                    <span>${comparar[j].cantidadReTwits} Retweets</span>  
                                </button>
                                <button class="link-style" type="button" onclick="modaleditartweet('${twit[i].codigoTwit}');">
                        <i class="fas fa-edit mr-2" aria-hidden="true"></i>
                        <span>Editar Tweet</span>
                    </button>
                            </div>
                        </div>`;
                    }
                }
            }
        }
    }).catch(error=>{
        console.error(error);
    });

}

generarTwits();

function guardarTwit() {
    document.getElementById("postTwit").disabled = true; //inabilitar boton
    let validacionTexto = validarCampoVacio("textoTwit");
    if (validacionTexto && document.getElementById("textoTwit").value.length <= 280) { //el texto tiene que ser mejor de 280 carateres 
        // "codigoTwit"         // clase PHP generar
        // "codigoUsuario"      // api PHP session
        // "contenidoTwit"      // twit publicado ***
        // "imagen"             // ""             ***
        // "cantidadReTwits"    // 0
        // "codigoTwitOriginal" // 0
        let twitParaGuardar ={
            contenidoTwit: document.getElementById("textoTwit").value,
            imagen: "",
            cantidadReTwits: 0,
            codigoTwitOriginal: 0
        };
        console.log('Twit a publicar', twitParaGuardar);
        
        axios({
            method: 'POST',
            url: urlTweets,
            responseType:'json',
            data:twitParaGuardar
        }).then(res=>{
            console.log(res); // Se devuelve en consola todos los tweets incluyendo el nuevo, abajo se imprimen en html con la funcion generarTwits()
            document.getElementById("postTwit").disabled = false;
            $("#formTweet").modal('hide');
            document.getElementById("textoTwit").value = '';
            document.getElementById("textoTwit").classList.remove("is-valid");
            document.getElementById("twits").innerHTML = "";
            generarTwits();

        }).catch(error=>{
            console.error(error);
            document.getElementById("postTwit").disabled = false;
        });
    } else {
        addInvalid("textoTwit");
        document.getElementById("postTwit").disabled = false;
    }
    
}

function compartirTweet(texto, idTwit) {
    // "codigoTwit"         // clase PHP generar
    // "codigoUsuario"      // api PHP session
    // "contenidoTwit"      // twit publicado ***
    // "imagen"             // ""             ***
    // "cantidadReTwits"    // clase PHP++
    // "codigoTwitOriginal" // twit publicado ***
    let twitParaCompartir ={
        contenidoTwit: texto,
        imagen: "",
        cantidadReTwits: 0,
        codigoTwitOriginal: idTwit
    };
    console.log('Twit a compartir', twitParaCompartir);
    axios({
        method: 'POST',
        url: urlTweets,
        responseType:'json',
        data:twitParaCompartir

    }).then(res=>{
        console.log(res); // Se devuelve en consola todos los tweets incluyendo el nuevo, abajo se imprimen en html con la funcion generarTwits()
        document.getElementById("twits").innerHTML = "";
        generarTwits();

    }).catch(error=>{
        console.error(error);
    });
}

 function modaleditartweet(idtweetEditar) {
     $("#edit").html(`<button id="postTwit" type="button" onclick="AcualizarTwit(${idtweetEditar})" class="btn btn-primary btn-lg col-sm-10 blue-tw-btn">Actualizar Tweet</button>`)
     $("#EditTweet").modal("show");

}