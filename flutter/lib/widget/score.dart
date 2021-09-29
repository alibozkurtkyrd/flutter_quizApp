import 'dart:io';

import 'package:async/async.dart';
import 'package:flutter/material.dart';
import 'package:flutter/rendering.dart';
import 'package:http/http.dart' as http;
import 'package:path/path.dart';
import 'package:url_launcher/url_launcher.dart';

//import 'package:quiz_staj/main.dart';

import '../Player.dart';
import '../main.dart';

const _url = 'http://192.168.43.243/final/getPlayer.php';

class Score extends StatefulWidget {
  @override
  static File resim;
  static String username;
  static String myScore;
  Player player;

  Score(this.player); // constructor

  void setResim(File img) {
    resim = img;
  }

  void setMyPoint(String points) {
    myScore = points;
  }

  String getMyPoint() {
    return myScore;
  }

  void setUserName(String name) {
    username = name;
  }

  String getUserName() {
    return username;
  }

  File getResim() {
    return resim;
  }

  _ScoreState createState() => _ScoreState();
}

class _ScoreState extends State<Score> {
  @override
  Future addPlayer() async {
    var stream = new http.ByteStream(
        DelegatingStream.typed(widget.player.getImage().openRead()));

    var length = await widget.player.getImage().length();
    var uri = Uri.parse("http://192.168.43.243/final/getFlutter2.php");
    var request = new http.MultipartRequest("POST", uri);
    var multipartFile = new http.MultipartFile("image", stream, length,
        filename: basename(widget.player.getImage().path));

    request.files.add(multipartFile);
    request.fields['name'] = widget.player.getName();
    request.fields['point'] = widget.player.getPoint().toString();
    request.fields['completion_time'] =
        widget.player.getCompletionTime().toString();
    //request.fields['now'] = DateTime.now().toString();
    request.fields['country'] = widget.player.getCountry();

    var respond = await request.send();

    if (respond.statusCode == 200) {
      print("Image Uploaded");
      //print(DateTime.now().toString());
    } else {
      print("Uploaded Failed");
    }
  }

  void _launchURL() async => await canLaunch(_url)
      ? await launch(_url)
      : throw 'Could not launch $_url';

  @override
  void initState() {
    addPlayer();
  }

  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        backgroundColor: Colors.teal,
        body: SafeArea(
          child: Padding(
            padding: EdgeInsets.all(30.0),
            child: Column(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                Text(
                  'Hi ${widget.player.getName()}',
                  style: TextStyle(
                    fontFamily: 'Pacifico',
                    fontSize: 40.0,
                    color: Colors.white,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                Container(
                  alignment: Alignment.center,
                  width: MediaQuery.of(context).size.width * 0.65,
                  height: MediaQuery.of(context).size.height * 0.4,
                  margin: EdgeInsets.only(top: 20),
                  decoration: BoxDecoration(
                    color: Colors.grey,
                    shape: BoxShape.circle,
                  ),
                  child: widget.player.getImage() == null
                      ? Center(
                          child: Icon(Icons.support_agent_outlined, size: 100))
                      : Image.file(widget.player.getImage()),
                ),
                Text(
                  "Your Score: ${widget.player.getPoint()}!",
                  style: TextStyle(
                    fontFamily: 'Source Sans Pro',
                    color: Colors.white,
                    fontSize: 30.0,
                    letterSpacing: 2.5,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                FloatingActionButton.extended(
                  onPressed: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(builder: (context) => QuizApp()),
                    );
                  },
                  label: const Text('New Quiz'),
                  icon: const Icon(Icons.repeat),
                  backgroundColor: Colors.amberAccent,
                ),
                FloatingActionButton.extended(
                  onPressed: _launchURL,
                  label: const Text('See Leadership Board'),
                  icon: const Icon(Icons.leaderboard_rounded),
                  backgroundColor: Colors.blue,
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
