# from _typeshed import FileDescriptorLike
from ibm_watson import AssistantV2
from ibm_cloud_sdk_core.authenticators import IAMAuthenticator
import json
import unicodedata  
from text_to_speech import talk
authenticator = IAMAuthenticator('doNAU1gEAcY9yNHmt9IJl6fhlhFzdLscb0fXzyo543T8')
assistant = AssistantV2(
    version='2021-06-14',
    authenticator=authenticator
)

assistant.set_service_url('https://api.eu-de.assistant.watson.cloud.ibm.com')
session = assistant.create_session("f0e8d7ca-4667-4a05-8f44-099b79955dd3").get_result()
# print(session)

def process(text):
    message = assistant.message(
        "f0e8d7ca-4667-4a05-8f44-099b79955dd3",
        session['session_id'],
        input={'text': text},
        context={
            'metadata': {
                'deployment': 'myDeployment'
            }
        }).get_result()

    # print(message)
    if ('text' in message['output']['generic'][0]):
        text=message['output']['generic'][0]['text']
        talk(text)
    elif  ('title' in message['output']['generic'][0]):
        text=message['output']['generic'][0]['title']+'\n'
        for i in message['output']['generic'][0]['options']:
            text+=i['label']+'\n'
    talk(text)    
    print (text)