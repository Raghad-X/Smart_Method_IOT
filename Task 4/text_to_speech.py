from ibm_watson import TextToSpeechV1
from ibm_cloud_sdk_core.authenticators import IAMAuthenticator

# 1. Authenticate
apikey = 'UhTQe8jmxVWVjVwz97POVToIrs1JvnGDN4chc_T-sFWA'
url = 'https://api.us-south.text-to-speech.watson.cloud.ibm.com/instances/42347314-ccec-4684-addc-8c84efed92bd'



def talk (text):
    # Setup Service
    authenticator = IAMAuthenticator(apikey)
    tts = TextToSpeechV1(authenticator=authenticator)
    tts.set_service_url(url)
    # print(text)
    with open('./speech.mp3', 'wb') as audio_file:
        res = tts.synthesize(text, accept='audio/mp3', voice='ar-MS_OmarVoice').get_result()
        audio_file.write(res.content)
# 3. Reading from a File
# with open('hr text.txt', 'r') as f:
#     text = f.readlines()
# text = [line.replace('\n','') for line in text]
# text = ''.join(str(line) for line in text)
# with open('./hr voice.mp3', 'wb') as audio_file:
#     res = tts.synthesize(text, accept='audio/mp3', voice='ar-MS_OmarVoice').get_result()
#     audio_file.write(res.content)