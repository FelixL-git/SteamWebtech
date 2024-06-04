from flask import Flask, jsonify, request
import mysql.connector

app = Flask(__name__)
app.config['SECRET_KEY'] = '4711'

# Datenbank Konfiguration # NEW
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'webtechsteam'
}

@app.route('/')
def hello_world():
    return 'Hello, World!'


@app.route('/login', methods=['POST'])
def login():
    # Benutzerdaten aus dem POST-Request abrufen
    username = request.form['username']
    password = request.form['password']

    # Datenbankverbindung aufbauen
    cnx = mysql.connector.connect(**db_config)
    cursor = cnx.cursor()

    # SQL-Befehl für die Benutzeranmeldung vorbereiten
    sql = ("SELECT * FROM user WHERE username = %s AND password = %s")

    # SQL-Befehl mit den Benutzerdaten ausführen
    cursor.execute(sql, (username, password))

    # Ergebnis der Abfrage überprüfen
    user = cursor.fetchone()

    # Datenbankverbindung schließen
    cursor.close()
    cnx.close()

    if user:
        # Weiterleitung zum Dashboard
        return jsonify({'status': '200', 'message': 'Erfolgreich eingeloggt'}, status=200)
    else:
        # Falsche Anmeldeinformationen
        return jsonify({'status': '401', 'message': 'Falsche Anmeldeinformationen'}, status=401)



@app.route('/user/<username>', methods=['GET'])
def overview(username):    
    # Datenbankverbindung aufbauen
    cnx = mysql.connector.connect(**db_config)
    cursor = cnx.cursor()
    
    # SQL-Befehl vorbereiten
    sql = ("SELECT * from series WHERE username = %s")
    
    # SQL Befehl ausführen
    cursor.execute(sql, (username,))
    # Daten aus dem Cursor holen.
    list_of_series = cursor.fetchall()
    
    # Verbindung schließen
    cursor.close()
    cnx.close()

    # Mit den Daten "list_of_students" das Template "overview.html" rendern. In der HTML-Datei heißt dann die
    # Variable "data". Die kann auch sonst wie heißen
    return jsonify(list_of_series)

if __name__ == '__main__':
    app.run()