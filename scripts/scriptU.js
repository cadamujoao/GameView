
// Pra definir o timer para, por exemplo, o keyup em ms
function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}


$(document).ready(function(){



    const inputsSemNumeros = document.querySelectorAll('.sem-numeros');
    const inputsSemEspeciais = document.querySelectorAll('.sem-especiais');

    // Não deixa digitar nem colar números
    inputsSemNumeros.forEach(input => {
        
        input.addEventListener('keypress', function (e) {

            if (/\d/.test(e.key)) {
                e.preventDefault();
            }
        });

        input.addEventListener('paste', function (e) {

            const pasted = (e.clipboardData || window.clipboardData).getData('text');

            if (/\d/.test(pasted)) {
                e.preventDefault();
            }
        });

    });
    // Não deixa digitar nem colar nada que não seja letras e espaço
    inputsSemEspeciais.forEach(input => {
    
        input.addEventListener('keypress', function (e) {
            
            if (!/^[a-zA-ZÀ-ÿ\s]$/.test(e.key)) {
                e.preventDefault();
            }
        });
    
        input.addEventListener('paste', function (e) {
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            if (/[^a-zA-ZÀ-ÿ\s]/.test(pasted)) {
                e.preventDefault();
            }
        });

    });



    // Verifica se o nome e/ou email já posssuí um registro no banco de dados

    let duplicadoNome = "";
    let duplicadoEmail = "";

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
                        nome.removeClass('is-valid').addClass('is-invalid'); // remove e add classes
                    } else {
                        duplicadoNome = response.status;
                        nome.removeClass('is-invalid').addClass('is-valid');
                    }

                },
                error: function(xhr, status, error) {
                    console.log("Erro na requisição: duplicaNome scriptU ", error);
                }
            });

        }else{
            nome.removeClass('is-valid').addClass('is-invalid');
        }

    },250));//Fim keyup nome



    $('#email').on('keyup',debounce(function(){
        let em = $(this).val();
        let email = $('#email');
        
        if(em != null & em != ""){

            $.ajax({
                url: "../codigo/duplicadoEmail.php",
                type: 'POST',
                data: {email: em},
                dataType: 'json',
                success: function(response) {

                    if (response.status) {
                        duplicadoEmail = response.status;
                        email.removeClass('is-valid').addClass('is-invalid');
                    } else {
                        duplicadoEmail = response.status;
                        email.removeClass('is-invalid').addClass('is-valid');
                    }

                },
                error: function(xhr, status, error) {
                    console.log("Erro na requisição: duplicaEmail scriptU   ", error);
                }
            });

        } else{
            email.removeClass('is-valid').addClass('is-invalid');
        }


    },250));//Fim keyup email



    // Botão de cadastrar
    $('#cadastrar').click(function(){

            if($('#nome').val()=='' || $('#nome').val()=="Seu nome"){
                alert("Nome inválido");
            }
            else if($('#email').val()=='' || $('#email').val()=="name@example.com"){
                alert("Email inválido");
                
            }else if($('#senha').val()=='' || $('#senha').val()=="senha"){
            alert("Senha inválida");
            
            }else if($('#confirma').val()=='' || $('#confirma').val()=="senha"){
                alert("Confirme a senha");

            }else if($('#senha').val()!=$('#confirma').val()){
                alert("As senhas estão diferentes");
            
            }else{
                no=$('#nome').val();
                em=$('#email').val();
                se=$('#senha').val();

                if(!duplicadoEmail && !duplicadoNome){

                    $.ajax({

                    url: '../codigo/cadUsuario.php',
                    type: 'POST',
                    data: {nome:no,email:em,senha:se},
                    dataType: 'json',
                    beforeSend: function() {
                        // Desabilita o botão cadastrar
                        $('#cadastrar').prop('disabled', true);
                    },
                    success: function(response){

                        console.log(response);


                        var resposta = response.status || "";
                        var dados = response.dados || "";
                        

                            if(resposta == "ok"){
                                alert("Confirme o email de verificação");

                                //window.location.href = "principal.php?id="+id+"&nome="+nome+"&tipo="+tipo;
                                // window.location.href = "../index.php?id="+dados;
                                window.location.href = "frmLogin.php";

                            }else if(resposta == "erro"){
                                alert("Erro:" + dados);
                                $('#cadastra').prop('disabled', false);

                            }else{
                                alert("Erro desconhecido");
                                $('#cadastra').prop('disabled', false);
                            }

                    
                    },
                    error: function(xhr, status, error){
                        console.log("Erro na requisição: ");
                    }
                    });//fim do ajax
                    
                }else if(duplicadoEmail && duplicadoNome){
                    alert("Nome e email já cadastrados!")
                }else if(duplicadoEmail){
                    alert("Email já cadastrados!")
                }else if(duplicadoNome){
                    alert("Usuário já cadastrados!")
                }

            }//fim do else

    });

});// fim do ready 
    
            
            

