from fastapi import FastAPI
import requests

# --- Configuration ---
# Get this from your Laravel app's /generate-token page
LARAVEL_API_TOKEN = "1|oQrSM4OLmqhpexyGTdyZWuCdEyq1zg2E0SsXlpZtcdeaf45f"
LARAVEL_API_ENDPOINT = "http://smart-glove-project.test/api/translations"
# -------------------

app = FastAPI()

@app.get("/")
def read_root():
    return {"message": "Glove Service is running"}

@app.post("/send-test-translation")
def send_test_data():
    """
    Simulates receiving data and sending it to the Laravel API.
    """
    headers = {
        'Authorization': f'Bearer {LARAVEL_API_TOKEN}',
        'Accept': 'application/json'
    }

    payload = {
        'translated_text': 'This is a test message from the Python service!'
    }

    try:
        response = requests.post(LARAVEL_API_ENDPOINT, json=payload, headers=headers)
        response.raise_for_status() # This will raise an error for bad responses (4xx or 5xx)
        return {"status": "success", "response_from_laravel": response.json()}
    except requests.exceptions.RequestException as e:
        return {"status": "error", "message": str(e)}