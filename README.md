# SteamWebtech

### Gruppenmitglieder
Dierking, Ole - 1715649; Gremm, Sebastian - 1715416; Langrehr, Felix - 1715429; Schulze, Nele - 1715665

### Beitrag der Mitglieder:
Ole Dierking: Ersetzen von SQL durch REST in login.php, dashboard.php und delete_series.php
Sebastian Gremm: Erstellen Grundstruktur der Python REST API
Felix Langrehr: Bewertungsfunktion (vollständig)
Nele Schulze: Ersetzen von SQL durch REST in dashboard.php und add_series.php

### Test-User
Username: admin
Passwort: admin

### DB-Konfiguration
 db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'webtechsteam'
}

### Verwendete Packages
Flask
mysql-connector-python
cURL

### Installieren des flask REST API Python Server
#### In Api Ordner wechseln:
```
cd flask
```

### Virtuelle Umgebung erstellen und aktivieren:
```
python -m venv venv
```

Mac:
```
source venv/bin/activate
```

Windows:
```
venv\Scripts\activate
```


#### Abhängigkeiten installieren:
```
pip install -r requirements.txt
```

#### (Wenn das nicht geht)
```
pip install Flask
pip install mysql-connector-python
```

#### Projekt ausführen:
```
python main.py
```


### Start flask REST API Python Server
```
cd flask

Windows:
venv\Scripts\activate

Mac:
source venv/bin/activate

python3 main.py
```