import 'dart:async';
import 'dart:convert';

import 'package:audioplayers/audioplayers.dart';
import 'package:circular_countdown_timer/circular_countdown_timer.dart';
import 'package:flutter/material.dart';
import 'package:fullscreen/fullscreen.dart';
import 'package:http/http.dart' as http;
import 'package:quiz_staj/Questions.dart';
import 'package:quiz_staj/widget/score.dart';

import '../Player.dart';

class JsonTest extends StatelessWidget {

  Player player;

  JsonTest(this.player); // constructor

  Future<List<Question>> fetchQuestion(http.Client client) async {

    final response = await client
        .get(Uri.parse('http://192.168.43.243/final/createJson.php'));
    return parseQuestion(response.body); // compute fonksiyonunu cıkardım
  }

  List<Question> parseQuestion(String responseBody) {
    final parsed = jsonDecode(responseBody).cast<Map<String, dynamic>>();

    return parsed.map<Question>((json) => Question.fromJson(json)).toList();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey.shade700,
      body: FutureBuilder<List<Question>>(
          future: fetchQuestion(http.Client()),
          builder: (context, snapshot) {
            if (snapshot.hasError) {
              return Center(
                child: Text('An error has occured!'),
              );
            } else if (snapshot.hasData) {
              return QuestionList(questions: snapshot.data, player: player);
            } else {
              return Center(
                child: CircularProgressIndicator(),
              );
            }
          }),
    );
  }
}

class QuestionList extends StatefulWidget {
  QuestionList({this.questions, this.player});
  Player player;
  final List<Question> questions;
  @override
  State<QuestionList> createState() => _QuestionListState();
}

class _QuestionListState extends State<QuestionList>
    with SingleTickerProviderStateMixin {
  //Score score = new Score(); // score instance is created

  int counter = 0;
  int totalPoint = 0;
  String userSelectedAnswer =
      "a"; // correctAnswer ve userSelectedAnswer e deger atamayınca null oluyor yesil yanıyor sıklar o yüzden a degerini verdim
  String correctAnswer;

  int selectedIndex; // listview de sık yakmak icin

  //static AudioCache playerAudio = AudioCache();
  final playerAudio = AudioCache();
  @override
  CountDownController _controller =
      CountDownController(); // geri sayımcı icin olusturuldu

  AnimationController controller;

  int UpperLimitGenerealTimer =
      60; // genel timerimiz icin üst limit (tüm sorular icin)
  @override
  void initState() {

    enterFullScreen(FullScreenMode.EMERSIVE_STICKY);
    controller = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 10),
    )..addListener(() {
        setState(() {

          if (controller.value == 1) {
            // this timer for each question individually

            if ((checkNextQuestionExist() == false) &&
                (checkPreviousQuestionExist() == false)) {
              // eger kullanıcı son soruda ise genelTimer süresi dolmamış olsa dahi son sorunun süresi
              // doldu ise quiz otomatik olarak bitmeli
              _showDialogForGeneralTimer();
            } else {
              _showDialog();
            }
          }

        });
      });
    controller.forward();

    super.initState();
  }

  @override
  void dispose() {
    controller.dispose();

    super.dispose();
  }

  int calculateCompletedTime() {
    // player in sınavı tamamlama süresini hesaplıyor
    return UpperLimitGenerealTimer - int.parse(_controller.getTime());
  }

  void enterFullScreen(FullScreenMode fullScreenMode) async {
    await FullScreen.enterFullScreen(fullScreenMode);
  }

  void exitFullScreen() async {
    await FullScreen.exitFullScreen();
  }

  void _showDialog() {
    // flutter defined function
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        // return object of type Dialog
        return AlertDialog(
          shape:
              RoundedRectangleBorder(borderRadius: BorderRadius.circular(20.0)),
          title: new Text("Time Is Up"),
          content: new Text("please past next question"),
          actions: <Widget>[
            // usually buttons at the bottom of the dialog
            new TextButton(
              child: new Text("Close"),
              onPressed: () {
                Navigator.of(context).pop();
                if (checkNextQuestionExist()) {
                  controller.stop();
                  controller.value = 0;
                  controller.forward();
                  setIsQuestionOpened(counter);
                  counter++;
                }
              },
            ),
          ],
        );
      },
    );
  }

  void _showDialogForGeneralTimer() {
    // flutter defined function
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        // return object of type Dialog
        return AlertDialog(
          backgroundColor: Colors.grey,
          shape:
              RoundedRectangleBorder(borderRadius: BorderRadius.circular(20.0)),
          title: new Text(
            "Time for Exam is ended...",
            style: TextStyle(
              fontFamily: 'Pacifico',
              fontSize: 25,
              color: Colors.white,
              fontWeight: FontWeight.bold,
            ),
          ),
          content: new Text(
            "Your score is calculated",
            style: TextStyle(
              fontFamily: 'Source Sans Pro',
              color: Colors.teal.shade100,
              fontSize: 18.0,
              letterSpacing: 1,
              fontWeight: FontWeight.bold,
            ),
          ),
          actions: <Widget>[
            // usually buttons at the bottom of the dialog
            new TextButton(
              child: new Text(
                "See my score",
                style: TextStyle(
                  fontFamily: 'Source Sans Pro',
                  color: Colors.greenAccent,
                  fontSize: 10.0,
                  letterSpacing: 1,
                  fontWeight: FontWeight.bold,
                ),
              ),
              onPressed: () {
                //score.setMyPoint(totalPoint.toString()); //TODO: daha sonra silinecek
                widget.player.setPoint(totalPoint);
                widget.player.setCompletionTime(
                    UpperLimitGenerealTimer); // yarısmacı upperlimitedTimer de tamamlamıs oluyor yani max sürede

                Navigator.push(
                  context,
                  MaterialPageRoute(builder: (context) => Score(widget.player)),
                );

                //Navigator.of(context).pop();
              },
            ),
          ],
        );
      },
    );
  }

  void _showDialogFalseChoices() {
    // flutter defined function
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (BuildContext context) {
        // return object of type Dialog
        return AlertDialog(
          title: new Text("Wrong Answer"),
          content: new Text(
              "Correct Answer is ${widget.questions[counter].questionAnswer}"),
          actions: <Widget>[
            // usually buttons at the bottom of the dialog
            new TextButton(
              child: new Text("Next Question"),
              onPressed: () {
                setState(() {

                  //print(_controller.getTime()); // genel timer in süresi
                  Navigator.of(context).pop();
                  if (checkNextQuestionExist()) {
                    controller.stop();
                    controller.value = 0;
                    controller.forward();
                    counter++;
                  }
                });
              },
            ),
          ],
        );
      },
    );
  }

  void checkUserAnswer(
      String userSelectedAnswer, String CorrectAnswer, bool flag) {
    // checkAnswerColor is called this function
    controller.stop();
    if (userSelectedAnswer == CorrectAnswer && flag) {
      totalPoint = totalPoint + 10;
      playerAudio.play('correct.wav');
    } else {
      playerAudio.play('wrong.wav');
      _showDialogFalseChoices(); // yanlıs kontorolü burada
    }
  }

  void setIsQuestionOpened(int counter) {
    // acılan her bir soruyu acılmıs olarak isaretleyecek
    bool test = widget.questions[counter].getIsQuestionOpened();

    if (widget.questions[counter].getIsQuestionOpened() == false) {
      widget.questions[counter].setIsQuestionOpened();
    }

    test = widget.questions[counter].getIsQuestionOpened();

  }

  bool checkPreviousQuestionExist() {
    // bir önceki soru var mı yok mu ona bakıyor
    if (counter - 1 >= 0) {
      return !(widget.questions[counter - 1]
          .getIsQuestionOpened()); // eger soru acılmadı ise sonuc true dönecek
    }

    return false;
  }

  bool checkNextQuestionExist() {
    // üsteki soruyu cevapladı ise de tekrar o soruya bakamaz
    // bir önceki soru var mı yok mu ona bakıyor

    if (counter + 1 <= widget.questions.length - 1) {
      return !(widget.questions[counter + 1].getIsQuestionOpened());
    }

    return false;
  }

  Color checkAnswerColor(String userSelectedAnswer, String CorrectAnswer) {
    //increaseTotalPoint();
    if (widget.questions[counter].userSelectedAnswer ==
            widget.questions[counter].questionAnswer &&
        userSelectedAnswer == widget.questions[counter].userSelectedAnswer &&
        (widget.questions[counter].isQuestionOpened)) {
      return Colors.green;
    }

    else if (userSelectedAnswer ==
            widget.questions[counter].userSelectedAnswer &&
        (widget.questions[counter].isQuestionOpened)) {

      return Colors.red;
    } else {

      return Colors.grey;
    }
  }

  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(8.0),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          Expanded(
            flex: 4,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceEvenly,
              children: [
                Padding(
                  padding: EdgeInsets.all(2.0),
                  child: CircleAvatar(
                    backgroundColor: Colors.blueGrey,
                    radius: 35.0,
                    child: Center(
                      child: Text(
                        "Question\n${counter + 1}/${widget.questions.length}",
                        textAlign: TextAlign.center,
                        style: TextStyle(
                          fontSize: 12,
                          color: Colors.white,
                        ),
                      ),
                    ),
                  ),
                ),
                CircularCountDownTimer(
                  duration: UpperLimitGenerealTimer,
                  initialDuration: 0,
                  controller: _controller,
                  width: MediaQuery.of(context).size.width / 4,
                  height: MediaQuery.of(context).size.height / 4,
                  ringColor: Colors.grey[300],
                  ringGradient: null,
                  fillColor: Colors.grey.shade500,
                  fillGradient: null,
                  backgroundColor: Colors.grey.shade700,
                  backgroundGradient: null,
                  strokeWidth: 20.0,
                  strokeCap: StrokeCap.round,
                  textStyle: TextStyle(
                      fontSize: 33.0,
                      color: Colors.white,
                      fontWeight: FontWeight.bold),
                  textFormat: CountdownTextFormat.S,
                  isReverse: true,
                  isReverseAnimation: true,
                  isTimerTextShown: true,
                  autoStart: true,
                  onStart: () {
                    //print('Countdown Started');
                  },
                  onComplete: () {
                    //print('Countdown Ended');
                    _showDialogForGeneralTimer();
                  },
                ),
                Padding(
                  padding: EdgeInsets.all(2.0),
                  child: CircleAvatar(
                    backgroundColor: Colors.blueGrey,
                    radius: 35.0,
                    child: Center(
                      child: Text(
                        "Point\n${totalPoint}",
                        textAlign: TextAlign.center,
                        style: TextStyle(
                          fontSize: 12,
                          color: Colors.white,
                        ),
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),
          SizedBox(
            height: 20,
          ),
          LinearProgressIndicator(
            value: controller.value,
          ),
          Expanded(
            flex: 5,
            child: Padding(
              padding: EdgeInsets.all(10.0),
              child: Scrollbar(
                child: SingleChildScrollView(
                  child: Center(
                    child: Text(
                      '${widget.questions[counter].questionText}',
                      textAlign: TextAlign.center,
                      style: TextStyle(fontSize: 30.0, color: Colors.white),
                    ),
                  ),
                ),
              ),
            ),
          ),
          Expanded(
            flex: 8,
            child: Center(
              child: Scrollbar(
                child: ListView.builder(
                  itemCount: widget.questions[counter].questionChoices.length,
                  itemBuilder: (context, index) {
                    return Padding(
                      padding: EdgeInsets.all(12.0),
                      child: FloatingActionButton(
                        heroTag: null,
                        backgroundColor: selectedIndex == index
                            ? checkAnswerColor(
                                userSelectedAnswer, correctAnswer)
                            : Colors.grey,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(50),
                        ),
                        child: Text(
                          widget.questions[counter].questionChoices[index]
                              .optionText,
                          style: TextStyle(
                            color: Colors.white,
                            fontSize: 15.0,
                          ),
                        ),
                        onPressed: () {
                          setState(() {
                            userSelectedAnswer = widget
                                .questions[counter]
                                .questionChoices[index]
                                .optionText; // kisini sectigi cevabı degiskene atadım

                            correctAnswer = widget.questions[counter]
                                .questionAnswer; // dogru cevabı alıyor
                            widget.questions[counter]
                                .setUserSelectedAnswer(userSelectedAnswer);
                            selectedIndex = index;
                            //print("selecteIndex: ${selectedIndex}");
                            // print("user selected answer ${userSelectedAnswer}");
                            // print("correct answer ${correctAnswer}");
                            //checkAnswerColor(userSelectedAnswer, correctAnswer);
                            checkUserAnswer(userSelectedAnswer, correctAnswer,
                                !(widget.questions[counter].isQuestionOpened));
                            setIsQuestionOpened(counter);
                          });
                        },
                      ),
                    );
                  },
                ),
              ),
            ),
          ),
          Expanded(
            flex: 3,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: <Widget>[
                FloatingActionButton(
                  heroTag: null,
                  onPressed: () {
                    setState(() {
                      if (checkPreviousQuestionExist()) {
                        controller.stop();
                        controller.forward();
                        counter--;
                      }
                    });
                  },
                  backgroundColor: Colors.white,
                  child: checkPreviousQuestionExist()
                      ? Icon(
                          Icons.arrow_back,
                          size: 50,
                          color: Colors.black,
                        )
                      : Icon(
                          Icons.visibility_off,
                          size: 50,
                          color: Colors.black,
                        ),
                ),
                FloatingActionButton.extended(
                  // sınavı bitirme puanı
                  heroTag: null,
                  onPressed: () async {
                    exitFullScreen();
                    //score.setMyPoint(totalPoint.toString()); //TODO: daha sonra silinecek
                    widget.player.setPoint(totalPoint);
                    widget.player.setCompletionTime(calculateCompletedTime());
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                          builder: (context) => Score(widget.player)),
                    );
                  },
                  label: const Text('End Quiz'),
                  icon: const Icon(Icons.stop_circle_outlined),
                  backgroundColor: Colors.deepOrange,
                ),
                FloatingActionButton(
                  heroTag: null,
                  onPressed: () {
                    setState(() {

                      if (checkNextQuestionExist()) {
                        controller.stop();
                        controller.value = 0;
                        controller.forward();
                        counter++;
                      }
                    });
                  },
                  backgroundColor: Colors.white,
                  child: checkNextQuestionExist()
                      ? Icon(
                          Icons.arrow_forward,
                          size: 50,
                          color: Colors.black,
                        )
                      : Icon(
                          Icons.visibility_off,
                          size: 50,
                          color: Colors.black,
                        ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
