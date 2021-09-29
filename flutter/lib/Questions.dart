class Question {
  String questionText;
  String questionAnswer; // correct answer

  List<Option>
      questionChoices; // burası generic olarak option alsa daha iyi olurdu

  bool isQuestionOpened =
      false; // puan hesaplarken eger bu open ise tekrar puan vermeyecek
  String userSelectedAnswer;
  Question({this.questionText, this.questionAnswer, this.questionChoices});

  factory Question.fromJson(Map<String, dynamic> json) {
    var list = json['options'] as List;
    //print(list.runtimeType);
    List<Option> optionList = list.map((i) => Option.fromJson(i)).toList();
    return Question(
        questionText: json['question_text'] as String,
        questionAnswer: json['correct_answer'] as String,
        questionChoices: optionList);
  }

  void setIsQuestionOpened() {
    isQuestionOpened = true;
  }

  bool getIsQuestionOpened() {
    return isQuestionOpened;
  }

  void setUserSelectedAnswer(String answer) {
    userSelectedAnswer = answer;
  }
}

class Option {
  String optionText;

  Option({this.optionText});

  factory Option.fromJson(Map<String, dynamic> json) {
    return Option(
      optionText: json['option_text'] as String,
    );
  }
}
