# Sistema de Login com RFID

Esse sistema de login com RFID é basicamente uma segurança para logar no sistema, pois para acessar é necessário uma autenticação utilizando a TAG RFID cadastrada no usuário.


# Hardware

Para a parte de hardware é **necessário**:

 1. ESP32
 2. 3x resistores
 3. 3x LEDs (tanto faz a cor, mas para fins de teste recomendo vermelho, amarelo e verde)
 4. Sensor RFID
 5. Jumpers
 
 A ligação utilizada no esquema foi baseada no site do  [FernadoK](https://www.fernandok.com/2018/02/esp32-com-rfid-controle-de-acesso.html), portanto segue abaixo:
 ![ESQUEMA PARCIAL](https://i.imgur.com/ANURvpX.png)

Para ligação dos LEDS, foram ligados na porta 2, 4 e 5, seguindo a ordem -> VERMELHO, AMARELO E VERDE.

# Sketch

O sketch está localizado no "sketchESP32". Para utilizá-lo é necessário colocar o nome da sua rede e senha e arrumar seu Endereço IPV4 para que o ESP32 tenha acesso ao link informado.

# Banco de Dados

O banco de dados está em dbRFID é apenas importá-lo. Após isso, crie um usuário, senha e coloque um código de RFID, algo como: XX XX XX XX (óbvio, utilize uma TAG válida para conseguir logar depois no sistema.

# Utilizando...

Para utilizar é simples acesse pelo localhost ou o famoso 127.0.0.1, o arquivo "login.php" e preencha suas credenciais. Após o modal aparecer, encoste sua credencial e aguarde o login.

# Utilidades

Esse sistema poderá ser utilizado em vários lugares, mas eu recomendaria se há necessidade de proteger algumas funções em seu sistema, como incluir usuário, produtos, descontos etc.

# Melhorias?

Sim, esse sistema precisa de algumas melhorias, tais como:

 1. Alguma criptografia ao enviar e receber dados do servidor
 2. Mexer melhor com a questão de sessões, inatividade do usuário...
 3. Melhorar o sistema de cadastro de usuário, existe algumas formas para cadastar a TAG com algum tipo de sequência de botões, algo como uma SENHA
 4. Entre alguns outros ajustes em redundâncias

