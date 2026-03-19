$(document).ready(function(){
    

    const inputH = document.getElementById('historia');
    const inputG = document.getElementById('graficos');
    const inputP = document.getElementById('performance');
    const inputJ = document.getElementById('jogabilidade');

    const valorH = document.getElementById('valorH');
    const valorG = document.getElementById('valorG');
    const valorP = document.getElementById('valorP');
    const valorJ = document.getElementById('valorJ');

    inputH.addEventListener('input', function() {
        valorH.textContent = this.value;
    });

    inputG.addEventListener('input', function() {
        valorG.textContent = this.value;
    });

    inputP.addEventListener('input', function() {
        valorP.textContent = this.value;
    });

    inputJ.addEventListener('input', function() {
        valorJ.textContent = this.value;
    });

    const texto = document.getElementById('texto');
    const num = document.getElementById('num');

    texto.addEventListener('input', function() {
        num.textContent = this.value.length;
    });



    $("#enviar").click(function(){
        
        
        let idjogo = document.getElementById('id');
        console.log(idjogo.value);

        $.ajax({
            url: "../codigo/analise.php",
            type: 'POST',
            data: {idjogo: idjogo.value, nH: inputH.value, nG: inputG.value, nP: inputP.value, nJ: inputJ.value, texto: texto.value},
            dataType: 'json',
            beforeSend: function() {
                // Desabilita o botão de login
                $('#enviar').prop('disabled', true);
            },
            success: function(response) {

                console.log(response);
                window.location.href = "frmHome.php";

                
            },
            error: function(xhr, status, error) {
                console.log("Erro na requisição:", error);s
                console.log("Resposta bruta:", xhr.responseText);
                $('#enviar').prop('disabled', false);
            }
        });

        
    });

    
    $("#confirmarEdt").click(function(){
        
        
        let idjogo = document.getElementById('id');
        console.log(idjogo.value);

        $.ajax({
            url: "../codigo/alterarAnalise.php",
            type: 'POST',
            data: {idjogo: idjogo.value, nH: inputH.value, nG: inputG.value, nP: inputP.value, nJ: inputJ.value, texto: texto.value},
            dataType: 'json',
            beforeSend: function() {
                // Desabilita o botão de login
                $('#confirmarEdt').prop('disabled', true);
            },
            success: function(response) {

                console.log(response);
                window.location.href = "frmHome.php";

                
            },
            error: function(xhr, status, error) {
                console.log("Erro na requisição:", error);
                console.log("Resposta bruta:", xhr.responseText);
                $('#enviar').prop('disabled', false);
            }
        });

        
    });

    $("#excluir").click(function(){
        
        
        let idjogo = document.getElementById('id');
        console.log(idjogo.value);

        $.ajax({
            url: "../codigo/excluirAnalise.php",
            type: 'POST',
            data: {idjogo: idjogo.value},
            dataType: 'json',
            success: function(response) {

                console.log(response);
                window.location.href = "frmHome.php";

                
            },
            error: function(xhr, status, error) {
                console.log("Erro na requisição:", error);
                console.log("Resposta bruta:", xhr.responseText);
                $('#excluir').prop('disabled', false);
            }
        });

        
    });



     $("#editar").click(function(){
        let idjogo = document.getElementById('id');

        window.location.href = "frmEditar.php?id=" + idjogo.value;

        

     });

     

});