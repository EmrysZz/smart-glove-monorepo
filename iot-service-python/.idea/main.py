from fastapi import FastAPI
from pydantic import BaseModel
import requests

# --- Configuration ---
LARAVEL_API_TOKEN = "1|oQrSM4OLmqhpexyGTdyZWuCdEyq1zg2E0SsXlpZtcdeaf45f" # Make sure this is a fresh token!
LARAVEL_API_ENDPOINT = "http://backend-laravel.test/api/translations"
# -------------------

app = FastAPI()

# Pydantic model to define the structure of incoming sensor data
class SensorData(BaseModel):
    flex_sensor_1: float
    flex_sensor_2: float
    gyro_x: float

@app.get("/")
def read_root():
    return {"message": "Glove Service is running"}

@app.post("/process-glove-data")
def process_glove_data(data: SensorData):
    """
    Receives simulated sensor data, 'translates' it,
    and sends the result to the Laravel API.
    """
    translated_text = "Unknown Sign"

    # Simulate the ML/translation logic
    if data.flex_sensor_1 > 0.8 and data.flex_sensor_2 < 0.2:
        translated_text = "Hello"
    elif data.flex_sensor_1 < 0.2 and data.flex_sensor_2 > 0.8:
        translated_text = "Goodbye"
    elif data.gyro_x > 15.0:
        translated_text = "Help"

    # --- Send the result to Laravel ---
    headers = {
        'Authorization': f'Bearer {LARAVEL_API_TOKEN}',
        'Accept': 'application/json'
    }
    payload = {
        'translated_text': translated_text
    }

    try:
        response = requests.post(LARAVEL_API_ENDPOINT, json=payload, headers=headers)
        response.raise_for_status() # Raise an error for bad responses
        return {"status": "success", "sent_to_laravel": payload, "laravel_response": response.json()}
    except requests.exceptions.RequestException as e:
        return {"status": "error", "message": str(e)}