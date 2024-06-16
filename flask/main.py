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

@app.route('/register', methods=['POST'])
def register():
    # Benutzerdaten aus dem POST-Request abrufen
    username = request.form['username']
    password = request.form['password']

    # Datenbankverbindung aufbauen
    cnx = mysql.connector.connect(**db_config)
    cursor = cnx.cursor()

    # SQL-Befehl für die Benutzerregistrierung vorbereiten
    sql = "INSERT INTO user (username, password) VALUES (%s, %s)"

    try:
        # SQL-Befehl ausführen
        cursor.execute(sql, (username, password))
        cnx.commit()  # Änderungen bestätigen
        result = {'status': 'success', 'message': 'Benutzer erfolgreich registriert'}
    except mysql.connector.Error as err:
        cnx.rollback()  # Rollback bei Fehler
        result = {'status': 'error', 'message': str(err)}
    finally:
        # Verbindung schließen
        cursor.close()
        cnx.close()

    return jsonify(result)


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
        # Richtige Anmeldeinformationen
        return jsonify({'status': 'success', 'message': 'Erfolgreich eingeloggt'})
    else:
        # Falsche Anmeldeinformationen
        return jsonify({'status': 'error', 'message': 'Falsche Anmeldeinformationen'})



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
    result = cursor.fetchall()
    
    # Verbindung schließen
    cursor.close()
    cnx.close()

    return jsonify(result)

@app.route('/user/<username>/series/<series_id>', methods=['DELETE'])
def delete_series(username, series_id):
    # Datenbankverbindung aufbauen
    cnx = mysql.connector.connect(**db_config)
    cursor = cnx.cursor()

    # SQL-Befehl vorbereiten
    sql = "DELETE FROM series WHERE username = %s AND id = %s"

    try:
        # SQL-Befehl ausführen
        cursor.execute(sql, (username, series_id))
        cnx.commit()  # Änderungen bestätigen
        result = {'status': 'success', 'message': 'Serie erfolgreich gelöscht'}
    except mysql.connector.Error as err:
        cnx.rollback()  # Rollback bei Fehler
        result = {'status': 'error', 'message': str(err)}
    finally:
        # Verbindung schließen
        cursor.close()
        cnx.close()

    return jsonify(result)

@app.route('/user/<username>/series', methods=['POST'])
def add_series(username):
    # Daten aus dem POST-Request abrufen
    title = request.form['title']
    genre = request.form['genre']
    platform = request.form['platform']
    seasons = request.form['seasons']

    # Datenbankverbindung aufbauen
    cnx = mysql.connector.connect(**db_config)
    cursor = cnx.cursor()

    # SQL-Befehl vorbereiten
    sql = "INSERT INTO series (Titel, Genre, Plattform, Staffeln, username) VALUES (%s, %s, %s, %s, %s)"

    try:
        # SQL-Befehl ausführen
        cursor.execute(sql, (title, genre, platform, seasons, username))
        cnx.commit()  # Änderungen bestätigen
        result = {'status': 'success', 'message': 'Serie erfolgreich hinzugefügt'}
    except mysql.connector.Error as err:
        cnx.rollback()  # Rollback bei Fehler
        result = {'status': 'error', 'message': str(err)}
    finally:
        # Verbindung schließen
        cursor.close()
        cnx.close()

    return jsonify(result)

@app.route('/user/<username>/change_rating', methods=['PUT'])
def change_rating(username):
    # Benutzerdaten, Serien-ID und abgegebene Sternezahl aus dem POST-Request abrufen
    username = request.form['username']
    series_id = request.form['series_id']
    rating = request.form['rating']

    # Datenbankverbindung aufbauen
    cnx = mysql.connector.connect(**db_config)
    cursor = cnx.cursor()

    # SQL-Befehl für die Rating-Änderung vorbereiten
    sql = "UPDATE series SET Bewertung = %s WHERE id = %s AND username = %s"

    try:
        # SQL-Befehl ausführen
        cursor.execute(sql, (rating, series_id, username))
        cnx.commit()  # Änderungen bestätigen
        result = {'status': 'success', 'message': 'Benutzer erfolgreich registriert'}
    except mysql.connector.Error as err:
        cnx.rollback()  # Rollback bei Fehler
        result = {'status': 'error', 'message': str(err)}
    finally:
        # Verbindung schließen
        cursor.close()
        cnx.close()

    return jsonify(result)

if __name__ == '__main__':
    app.run()