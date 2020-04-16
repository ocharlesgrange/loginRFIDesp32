#include <MFRC522.h>
#include <SPI.h>
#include <WiFi.h>
#include <HTTPClient.h>
#define SS_PIN    21
#define RST_PIN   22

const char* ssid = "nome do seu wifi";
const char* password = "senha do wifi";

MFRC522::MIFARE_Key key;
MFRC522::StatusCode status;

MFRC522 mfrc522(SS_PIN, RST_PIN);

void setup() {
  pinMode(2, OUTPUT);
  pinMode(4, OUTPUT);
  pinMode(5, OUTPUT);
  Serial.begin(115200);
  delay(4000);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Tentando realizar conexão...");
  }
  Serial.println("Conectado na rede WiFi.");
  SPI.begin();
  mfrc522.PCD_Init();
}

void loop() {
  if ( ! mfrc522.PICC_IsNewCardPresent())
  {
    return;
  }
  // Seleciona um dos cartoes
  if ( ! mfrc522.PICC_ReadCardSerial())
  {
    return;
  }
  if ((WiFi.status() == WL_CONNECTED)) {
    String conteudo = "";
    byte letra;
    for (byte i = 0; i < mfrc522.uid.size; i++)
    {
      conteudo.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : "%20"));
      conteudo.concat(String(mfrc522.uid.uidByte[i], HEX));
    }
    HTTPClient http;
    conteudo.toUpperCase();
    String iddorfid = conteudo.substring(3);
    Serial.println(iddorfid);
    http.begin("http://ENDEREÇO IPV4/rfid.php?acao=access&rfid=" + iddorfid);
    int httpCode = http.GET();
    if (httpCode > 0) {
      String payload = http.getString();
      if (payload == "error_access") {
        digitalWrite(2, HIGH);
        digitalWrite(4, LOW);
        digitalWrite(5, LOW);
      }
      else if (payload == "credential_insert") {
        digitalWrite(2, LOW);
        digitalWrite(4, HIGH);
        digitalWrite(5, LOW);
      }
      else if (payload == "ok_access") {
        digitalWrite(2, LOW);
        digitalWrite(4, LOW);
        digitalWrite(5, HIGH);
      }
    }
    else {
      Serial.println("Error on HTTP request");
    }
    http.end();
  }
  delay(2000);
  digitalWrite(2, LOW);
  digitalWrite(4, LOW);
  digitalWrite(5, LOW);
  delay(5000);
}
