<?php
    function traduzirGratis($texto, $alvo = 'pt', $origem = 'auto') {
      $linhas = preg_split('/(\r\n|\n)/', trim($texto));
      $resultadoFinal = [];
  
      foreach ($linhas as $linha) {
          $linha = trim($linha);
          if ($linha === '') {
              $resultadoFinal[] = ''; // preserva linhas vazias
              continue;
          }
  
          $url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=$origem&tl=$alvo&dt=t&q=" . urlencode($linha);
          $resposta = @file_get_contents($url);
          if ($resposta === false) {
              $traduzido = $linha;
          } else {
              $json = json_decode($resposta, true);
              $traduzido = $json[0][0][0] ?? $linha;
          }
  
          // Remove espaços extras
          $traduzido = trim($traduzido);
  
          // Adiciona ponto final se não houver
          if (!preg_match('/[.!?]$/', $traduzido)) {
              $traduzido .= '.';
          }
  
          $resultadoFinal[] = $traduzido;
      }
  
      return implode("\n", $resultadoFinal);

  }
?>