from sat import sat # on inclu la fonction sat du fichier sat.py
from ping import ping # on inclu la fonction ping du fichier ping.py
import threading # on inclu la bibliothèque threading (pour exécuter plusieurs script en parallèle)
from time import sleep # on inclu la fonction sleep de la bibliothèque time (pour marquer des temps d'arrêt dans le code)

# Hôte sur lequel on va faire les tester
# A rendre dynamique plus tard
host = "projet-slam.freeboxos.fr"

# Ports à tester (seuls ports ouverts sur le serveur à part 80, 21, 22, 3306)
# A rendre dynamique plus tard
p1 = 8000
p2 = 8001
p3 = 8002

def test(duree, port, host):
    # Début Saturation
    print(f'------------------------ Début de la saturation du port {port} ------------------------')
    # on crée un thread (le code s'exécute sur une autre partie du processeur) pour que la saturation puisse s'effectuer en parallèle du ping
    download_thread = threading.Thread(target=sat, args=(duree, port, host))
    download_thread.start()
    
    # Début mesure du ping
    res = ping(duree, port, host) # on récupère les résultats du ping dans une variable
    print(f'------------------------ Fin de la saturation du port {port} ------------------------')
    sleep(2) # on attend 2 secondes pour une meilleure lisibilité
    return res

data = {} # dictionnaire vide
for port in [p1, p2, p3]: # pour chaque port
    port_mesures = test(10, port, host) # on récupère dans une variable les mesures effectuées sur le port
    data[port] = port_mesures # on les mets dans le dictionnaire

print(data) # pour le moment on affiche. Plus tard, insertion dans la base de données


# A faire :
# hôte et ports dynamiques (quand les filles auront avancé)
# faire fonctionner nethogs
# vrai gestion des erreurs
# préparer les données pour l'envoi en BDD
# fusionner ping et tcpping ?