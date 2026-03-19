$(document).ready(function(){

    // Mostra ou esconde a senha
    $('#ver').click(function() {
        let senha = document.getElementById("senha");
        senha.type = senha.type === "password" ? "text" : "password";
    });


    // Botão de login
    $('#login').click(function() {

        if ($('#email').val() == '') {
            alert("Email inválido");
        } else if ($('#senha').val() == '') {
            alert("Senha inválida");
        } else {
            var em = $('#email').val();
            var se = $('#senha').val();

            $.ajax({
                url: "../codigo/pesquisaLogin.php",
                type: 'POST',
                data: { email: em, senha: se },
                dataType: 'json',
                beforeSend: function() {
                    // Desabilita o botão de login
                    $('#login').prop('disabled', true);
                },
                success: function(response) {

                    if (response.erro) {
                        alert("Usuário ou senha inválidos");
                        $('#login').prop('disabled', false);
                    } else {

                        console.log(response);
                        window.location.href = $('#redirecionar').val();
                    
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Erro na requisição:", error);
                    $('#login').prop('disabled', false);
                }
            });
        }
    });


    // Botão de esqueci a senha
    $('#esqueci').click(function() {

        if ($('#email').val() == '') {
            alert("Email inválido");
        } else {
            var em = $('#email').val();

            $.ajax({
                url: "../codigo/pesquisaEsqueci.php",
                type: 'POST',
                data: { email: em },
                dataType: 'json',
                beforeSend: function() {
                    // Desabilita o botão de login
                    $('#esqueci').prop('disabled', true);
                },
                success: function(response) {

                    if (response.erro) {
                        alert("Usuário não encontrado!");
                        $('#esqueci').prop('disabled', false);
                    } else {

                        console.log(response.resultado);

                        alert("Abra seu email e redefina sua senha!");
                        window.location.href = "frmLogin.php";

                    }
                },
                error: function(xhr, status, error) {
                    console.log("Erro na requisição:", error);
                    $('#esqueci').prop('disabled', false);
                }
            });
        }
    });



    



    // Botão de confirmar a alteração da senha
    $('#confirmar').click(function() {

       if($('#senha').val()=='' || $('#senha').val()=="senha"){
            alert("Senha inválida");
            
        }else if($('#confirma').val()=='' || $('#confirma').val()=="senha"){
            alert("Confirme a senha");

        }else if($('#senha').val()!=$('#confirma').val()){
            alert("As senhas estão diferentes");
        
        } else {
            var se = $('#senha').val();
            var token = $('#token').val();

            $.ajax({
                url: "../codigo/redefinirSenha.php",
                type: 'POST',
                data: { senha: se, token: token },
                dataType: 'json',
                beforeSend: function() {
                    // Desabilita o botão de login
                    $('#confirmar').prop('disabled', true);
                },
                success: function(response) {

                    if (response.erro) {
                        alert("Erro ao alterar a senha!");
                        $('#esqueci').prop('disabled', false);
                    } else {

                        console.log(response);


                        alert("Senha alterada com sucesso!");
                        window.location.href = "frmLogin.php";

                    }
                },
                error: function(xhr, status, error) {
                    console.log("Erro na requisição:", error);
                    $('#confirmar').prop('disabled', false);
                }
            });
        }
    });


});

