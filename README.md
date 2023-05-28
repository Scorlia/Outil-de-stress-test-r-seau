# Programme Python de test de la saturation réseau



## **Usage**
Ce programme sert à tester la charge réseau sur des ports TCP spécifiés. Il prend en entrée un paramétrage (port 1, port2, port3, durée de test, hôte) et renvoie en sortie les temps de réponses au ping qu'il a observés

## **Code externe utilisé**

### Librairies python
- time (time, sleep)
- os (getcwd)
- pymysql
- subprocess
- threading

### Librairies externes
- [nethogs](https://github.com/raboof/nethogs)
- [tcpping](https://github.com/yantisj/tcpping)