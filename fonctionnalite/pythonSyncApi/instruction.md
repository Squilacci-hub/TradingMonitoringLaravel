Architecture de Synchronisation Exness (Python -> Laravel)
Cette approche utilise un script Python comme Listener sur le terminal MetaTrader 5 (MT5) pour envoyer les données vers l'API Laravel via des requêtes HTTP.

1. Prérequis Système
Windows (obligatoire pour la librairie MetaTrader5).

Terminal MT5 Exness installé et connecté à ton compte de trading.

Python 3.10+ installé.

2. Étape 1 : Préparer l'API Laravel
Côté Laravel, tu dois créer un "Endpoint" sécurisé pour recevoir les données du script Python.

Route : Crée une route POST dans routes/api.php.

Controller : Crée un TradeSyncController qui valide les données (ticket ID, profit, symbole) et les enregistre en base de données.

Sécurité : Utilise un API_TOKEN simple dans ton fichier .env pour que seul ton script Python puisse poster des données.

3. Étape 2 : Le Script Python (Le "Bridge")
Le script Python va agir comme un service qui tourne en arrière-plan.

Installation : pip install MetaTrader5 pandas requests.

Logique du script :

Initialiser la connexion avec mt5.initialize().

Récupérer le dernier ticket enregistré dans Laravel (via un GET).

Utiliser mt5.history_deals_get(from_date, to_date) pour l'historique récent.

Boucler sur les nouveaux trades fermés.

Envoyer chaque trade vers Laravel via la librairie requests.post().

4. Étape 3 : Automatisation
Pour que la synchronisation soit "temps réel" ou régulière :

Option A (Boucle) : Utiliser une boucle while True: avec un time.sleep(60) dans le script Python.

Option B (Tâche planifiée) : Utiliser le Planificateur de tâches Windows pour exécuter le script toutes les 5 minutes.

5. Flux de données
Exness (MT5) : Le trade se ferme.

Python : Détecte la nouvelle ligne dans l'historique MT5.

Laravel : Reçoit le JSON, calcule les stats (Win Rate, Profit Factor) et met à jour ton Dashboard.