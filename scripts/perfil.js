function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

let duplicadoNome = "";

$(document).ready(function(){

$('#nome').on('keyup',debounce(function(){
    let no = $(this).val();
    let nome = $('#nome');

    if(no != null & no != ""){

        $.ajax({
            url: "../codigo/duplicadoNome.php",
            type: 'POST',
            data: {nome: no},
            dataType: 'json', // retorna em json, não array
            success: function(response) {
            
                if (response.status) {
                    duplicadoNome = response.status;
                    alert("Nome já cadastrado!");
                } else {
                    duplicadoNome = response.status;
                    alert("Nome disponível!");
                }

            },
            error: function(xhr, status, error) {
                console.log("Erro na requisição: duplicaNome scriptU ", error);
            }
        });

    }else{
        nome.removeClass('is-valid').addClass('is-invalid');
    }

},250));






    $('#confirmar').click(function() {

       if($('#novoEmail').val()=='' || $('#novoEmail').val()=="senha"){

            alert("Email inválido");

        } else {
            var email = $('#novoEmail').val();
            var token = $('#token').val();

            $.ajax({
                url: "../codigo/alterarEmail.php",
                type: 'POST',
                data: { email: email, token: token },
                dataType: 'json',
                beforeSend: function() {
                    // Desabilita o botão de login
                    $('#confirmar').prop('disabled', true);
                },
                success: function(response) {

                    if (response.erro) {
                        if(response.dados == 'duplicado'){
                            alert('Esse email já foi cadastrado!')
                        }else{
                        alert("Erro ao alterar o email!");
                        $('#confirmar').prop('disabled', false);
                        }
                    } else {

                        alert("Email alterado com sucesso!");
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


     $('#deletar').click(function() {
        let confirmar = confirm("Tem certeza que deseja excluir sua conta?");

        if (confirmar) {
    
            const id = $('#idusuario').val();
        

            $.ajax({
                url: "../codigo/excluirPerfil.php",
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                beforeSend: function() {
                    // Desabilita o botão de login
                    $('#deletar').prop('disabled', true);
                },
                success: function(response) {

                    
                        window.location.href = "frmLogin.php";
                        
                    
                },
                error: function(xhr, status, error) {
                    console.log("Erro na requisição:", error);
                    $('#deletar').prop('disabled', false);
                }
            });

        }
        
    });






});