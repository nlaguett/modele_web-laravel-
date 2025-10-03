import sys
import pandas as pd
from fbprophet import Prophet
import json

# Récupérer les données JSON envoyées par CodeIgniter
data = json.loads(sys.stdin.read())

# Convertir en DataFrame
df = pd.DataFrame(data)
df.rename(columns={'date': 'ds', 'stock': 'y'}, inplace=True)  # Prophet nécessite ces noms

# Initialiser Prophet et ajuster le modèle
model = Prophet()
model.fit(df)

# Faire une prévision sur 30 jours
future = model.make_future_dataframe(periods=30)
forecast = model.predict(future)

# Sélectionner les données utiles
result = forecast[['ds', 'yhat', 'yhat_lower', 'yhat_upper']].tail(30).to_dict(orient='records')

# Retourner les résultats
print(json.dumps(result))
