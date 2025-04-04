import mysql.connector
from telebot import TeleBot, types
# Initialize the bot
bot = TeleBot("your id ")
# Connect to the MySQL database
db_config = {
    'host': 'localhost',         # Replace with your MySQL server host
    'user': 'root',              # Replace with your MySQL username
    'password': '',              # Replace with your MySQL password
    'database': 'customermanagement'  # Replace with your database name
}
conn = mysql.connector.connect(**db_config)
cursor = conn.cursor()
# Create the necessary table if it doesn't exist
# Global dictionary to track user states
user_states = {}
# Questions
questions = [
    "1. እራሴን ለማረጋጋት እቸገራለሁ?",  
    "2. አፌ ሲደርቅ ይታወቀኛል?",  
    "3. ጥሩ ወይም አዎንታዊ ስሜት ፈፅሞ የሚሰማኝ አይመስለኝም?",  
    "4. ምንም አካላዊ እንቅስቃሴ ሳላደርግ ለመተንፈስ እቸገራለሁ፤ ለምሳሌ ከመጠን በላይ በፍጥነት የመተንፈስ ወይም የትንፋሽ ማጠር ያስቸግረኛል?"
]

# Helper function to save user details and responses
def save_user_response(user_id, name, question_number, question, response):
    cursor.execute("""
        INSERT INTO customers (user_id, name, question_number, question, response)
        VALUES (%s, %s, %s, %s, %s)
        ON DUPLICATE KEY UPDATE response = VALUES(response)
    """, (user_id, name, question_number, question, response))
    conn.commit()
# Function to create inline buttons
def create_radio_buttons():
    markup = types.InlineKeyboardMarkup()
    buttons = [
        types.InlineKeyboardButton("0 = ፍፁም እኔን አይገልፀኝም", callback_data='0'),
        types.InlineKeyboardButton("1 = በተወሰነ ደረጃ ወይም አንዳንዴ ይገልፀኛል", callback_data='1'),
        types.InlineKeyboardButton("2 = በደንብ አድርጎ ወይም ብዙ ጊዜ ይገልፀኛል", callback_data='2'),
        types.InlineKeyboardButton("3 = በከፍተኛ ደረጃ ወይም ሁል ጊዜ ይገልፀኛል", callback_data='3')
    ]
    markup.add(*buttons)
    return markup
@bot.message_handler(commands=['start', 'help'])
def send_welcome(message):
    user_id = message.chat.id
    user_states[user_id] = {'state': 'asking_name', 'name': '', 'progress': 0}
    bot.reply_to(message, "እባኮትን ስምዎን ያስገቡ ለመጀመር።")
@bot.message_handler(func=lambda message: user_states.get(message.chat.id, {}).get('state') == 'asking_name')
def ask_name(message):
    user_id = message.chat.id
    user_states[user_id]['name'] = message.text
    user_states[user_id]['state'] = 'ready_for_questions'
    bot.reply_to(message, f"እንኳን ደህና መጡ {message.text}! እያንዳንዱን ጥያቄ በጥሞና በማዳመጥ የአንተን/ችን ሁኔታ ይበልጥ የሚገልፀዉን መልስ ከተሰጡት አራት አማራጮች አንዱን መልስ(ሽ)       የጥያቄዎችን ሂደት ለመጀመር Yes ብለው ይጥጻፉ ለማቋረጥ ከፈለጉ Exit ይጥጻፉ ብለው።")
@bot.message_handler(func=lambda message: message.text.lower() == "yes" and user_states.get(message.chat.id, {}).get('state') == 'ready_for_questions')
def start_questions(message):
    user_id = message.chat.id
    progress = user_states[user_id]['progress']
    bot.reply_to(message, questions[progress], reply_markup=create_radio_buttons())
@bot.callback_query_handler(func=lambda call: call.data in ['0', '1', '2', '3'])
def handle_response(call):
    user_id = call.message.chat.id
    user_data = user_states[user_id]
    name = user_data['name']
    progress = user_data['progress']
    question = questions[progress]
    response = call.data
    # Save the response in the database
    save_user_response(user_id, name, progress + 1, question, response)
    # Move to the next question or end
    if progress + 1 < len(questions):
        user_states[user_id]['progress'] += 1
        bot.edit_message_text(questions[progress + 1], chat_id=user_id, message_id=call.message.message_id, reply_markup=create_radio_buttons())
    else:
        bot.edit_message_text("ሁሉንም ጥያቂ በሚገባ ስለመለሱ እናመሰናለን.", chat_id=user_id, message_id=call.message.message_id)
        user_states[user_id]['state'] = 'completed'
@bot.message_handler(func=lambda message: message.text.lower() == "exit")
def exit_bot(message):
    bot.reply_to(message, "ከሲስተሙ ወተዋል. እናመሰግናለን!")

# Start the bot
bot.infinity_polling()
