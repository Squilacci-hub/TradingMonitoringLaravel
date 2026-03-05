import sys
import json
import datetime

try:
    import MetaTrader5 as mt5
except ImportError:
    print(json.dumps({"success": False, "error": "Library MetaTrader5 not found. Please run 'py -m pip install MetaTrader5'"}))
    sys.exit(1)

# Configuration pour forcer MT5 à utiliser les comptes Exness
# Note: MT5 doit être déjà installé et configuré sur le PC

def main():
    if len(sys.argv) < 5:
        print(json.dumps({"success": False, "error": "Missing arguments. Usage: python mt5_bridge.py <mode> <login> <password> <server>"}))
        return

    mode = sys.argv[1] # 'verify' ou 'fetch'
    try:
        login = int(sys.argv[2])
    except ValueError:
        print(json.dumps({"success": False, "error": "Login must be an integer"}))
        return
        
    password = sys.argv[3]
    server = sys.argv[4]

    # Initialiser MT5 avec les identifiants
    if not mt5.initialize(login=login, password=password, server=server):
        err = mt5.last_error()
        # Tentative de recherche automatique du terminal si l'init par défaut échoue
        common_paths = [
            r"C:\Program Files\MetaTrader 5\terminal64.exe",
            r"C:\Program Files\Exness MetaTrader 5\terminal64.exe",
            r"C:\Program Files (x86)\Exness MetaTrader 5\terminal64.exe"
        ]
        
        success = False
        for path in common_paths:
            import os
            if os.path.exists(path):
                if mt5.initialize(path=path, login=login, password=password, server=server):
                    success = True
                    break
        
        if not success:
            print(json.dumps({
                "success": False, 
                "error": f"Failed to connect to MT5: {err}. Assurez-vous que MT5 est ouvert ou installé dans le chemin par défaut. Erreur IPC: {err}"
            }))
            return

    if mode == 'verify':
        account_info = mt5.account_info()
        if account_info:
            print(json.dumps({
                "success": True, 
                "balance": account_info.balance, 
                "equity": account_info.equity,
                "currency": account_info.currency,
                "name": account_info.name,
                "server": account_info.server
            }))
        else:
            print(json.dumps({"error": "Could not get account info"}))
    
    elif mode == 'fetch':
        # Récupérer les deals (historique)
        from_date = datetime.datetime.now() - datetime.timedelta(days=90) # 3 derniers mois par défaut
        to_date = datetime.datetime.now()
        
        # Deals (Transactions terminées)
        deals = mt5.history_deals_get(from_date, to_date)
        
        # Positions (Trades ouverts)
        positions = mt5.positions_get()
        
        results = {
            "success": True,
            "closed_deals": [],
            "open_positions": []
        }
        
        if deals:
            for d in deals:
                # On ne prend que les deals qui sont des entrées ou sorties de marché (pas les dépôts par exemple)
                if d.type in [mt5.DEAL_TYPE_BUY, mt5.DEAL_TYPE_SELL]:
                    results["closed_deals"].append({
                        "ticket": d.ticket,
                        "position_id": d.position_id,
                        "symbol": d.symbol,
                        "type": "buy" if d.type == mt5.DEAL_TYPE_BUY else "sell",
                        "volume": d.volume,
                        "price": d.price,
                        "time": d.time, # timestamp
                        "profit": d.profit,
                        "commission": d.commission,
                        "swap": d.swap,
                        "comment": d.comment,
                        "entry": d.entry # 0: IN, 1: OUT
                    })

        if positions:
            for p in positions:
                results["open_positions"].append({
                    "ticket": p.ticket,
                    "symbol": p.symbol,
                    "type": "buy" if p.type == mt5.POSITION_TYPE_BUY else "sell",
                    "volume": p.volume,
                    "price_open": p.price_open,
                    "time": p.time,
                    "profit": p.profit,
                    "comment": p.comment
                })
        
        print(json.dumps(results))

    mt5.shutdown()

if __name__ == "__main__":
    main()
