

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Envio de Imagens</title>
<style>
    body {
        font-family: "Segoe UI", sans-serif;
        background: #f5f6f8;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding-top: 60px;
    }

    .upload-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        padding: 30px;
        width: 90%;
        max-width: 500px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    form {
        border: 2px dashed #007bff;
        border-radius: 10px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    form:hover {
        background: #f0f8ff;
    }

    input[type="file"] {
        display: none;
    }

    label {
        display: block;
        font-size: 1rem;
        color: #007bff;
        cursor: pointer;
        margin-bottom: 10px;
    }

    button {
        background: #007bff;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #0056b3;
    }

    .preview {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 15px;
        gap: 10px;
    }

    .preview img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .mensagens {
        margin-top: 20px;
        text-align: left;
        font-size: 0.9rem;
    }
</style>
</head>
<body>

<div class="upload-container">
    <h2>Enviar Imagens</h2>
    <form method="POST" enctype="multipart/form-data" id="formUpload">
        <label for="imagens">Clique ou arraste as imagens aqui</label>
        <input type="file" name="imagens[]" id="imagens" multiple accept="image/*">
        <div class="preview" id="preview"></div>
        <button type="submit">Enviar</button>
    </form>

    <?php if (!empty($mensagens)): ?>
        <div class="mensagens">
            <h3>Resultado:</h3>
            <?php foreach ($mensagens as $m): ?>
                <p><?= $m ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    // Pré-visualização das imagens
    const input = document.getElementById('imagens');
    const preview = document.getElementById('preview');

    input.addEventListener('change', () => {
        preview.innerHTML = "";
        const files = input.files;

        for (const file of files) {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>
