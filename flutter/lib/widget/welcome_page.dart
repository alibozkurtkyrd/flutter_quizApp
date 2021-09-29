import 'dart:io';

import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutter/rendering.dart';
import 'package:flutter/services.dart';
import 'package:image_picker/image_picker.dart';
import 'package:quiz_staj/translations/locale_keys.g.dart';

import '../Player.dart';
import 'questionPage.dart';

class startingPage extends StatefulWidget {
  @override
  State<startingPage> createState() => _startingPageState();
}

class _startingPageState extends State<startingPage> {
  @override
  File _image = null;
  bool isUserTakePicture = false;

  Player player = Player(); // object is created
  final imagePicker = ImagePicker();
  final myController = TextEditingController();


  void dispose() {
    myController.dispose();
    super.dispose();
  }

  Future getImage() async { // function did taking picture from camera
    try {
      final image = await imagePicker.pickImage(source: ImageSource.camera);

      if (image == null) return;
      setState(() {
        _image = File(image.path);
      });

      player.setImage(_image);
      isUserTakePicture = true;
    } on PlatformException catch (e) {
      print('Failed to pick image $e');
    }

  }

  Widget build(BuildContext context) {
    String dropdownValue = 'Language';
    void _showDialog() {
      // flutter defined function
      showDialog(
        context: context,
        builder: (BuildContext context) {
          // return object of type Dialog
          return AlertDialog(
            title: new Text(LocaleKeys.no_photo.tr()),
            content: new Text(LocaleKeys.please_take_photo.tr()),
            actions: <Widget>[
              // usually buttons at the bottom of the dialog
              new TextButton(
                child: new Text("Close"),
                onPressed: () {
                  Navigator.of(context).pop();
                },
              ),
            ],
          );
        },
      );
    }

    return SingleChildScrollView(
      child: Container(
        child: Padding(
          padding: const EdgeInsets.all(20.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            crossAxisAlignment: CrossAxisAlignment.end,
            children: <Widget>[
              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 4.0),
                child: Row(
                  children: [
                    Expanded(
                      flex: 2,
                      child: Text(
                        LocaleKeys.welcome_text.tr(),
                        style: TextStyle(
                          fontFamily: 'Pacifico',
                          fontSize: 25.0,
                          color: Colors.white,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                    Expanded(
                      child: DropdownButton<String>(
                        value: dropdownValue,
                        icon: const Icon(Icons.arrow_downward),
                        iconSize: 10,
                        elevation: 16,
                        style: const TextStyle(color: Colors.deepPurple),
                        underline: Container(
                          height: 2,
                          color: Colors.deepPurpleAccent,
                        ),
                        onChanged: (String newValue) {
                          setState(() {
                            dropdownValue = newValue;

                            if (newValue == "Türkçe" ||
                                newValue == "Language") {
                              context.setLocale(Locale('tr'));
                            } else if (newValue == "English") {
                              context.setLocale(Locale('en'));
                            }
                          });
                        },
                        items: <String>['Language', 'Türkçe', 'English']
                            .map<DropdownMenuItem<String>>((String value) {
                          return DropdownMenuItem<String>(
                            value: value,
                            child: Text(value),
                          );
                        }).toList(),
                      ),
                    )
                  ],
                ),
              ),
              Center(
                child: Container(
                  width: MediaQuery.of(context).size.width * 0.65,
                  height: MediaQuery.of(context).size.height * 0.4,
                  margin: EdgeInsets.only(top: 20),
                  decoration: BoxDecoration(
                    color: Colors.grey,
                    shape: BoxShape.circle,
                  ),
                  child: _image == null
                      ? Center(
                          child: Icon(Icons.support_agent_outlined, size: 100))
                      : Image.file(_image),
                ),
              ),
              SizedBox(
                height: 20,
              ),
              TextField(
                controller: myController,
                style: TextStyle(
                  fontFamily: 'Source Sans Pro',
                  color: Colors.teal.shade100,
                  fontSize: 20.0,
                  letterSpacing: 2.5,
                  fontWeight: FontWeight.bold,
                ),
                decoration: InputDecoration(
                    border: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(30),
                    ),
                    labelText: LocaleKeys.enter_yourName.tr()),
              ),
              SizedBox(
                height: 20,
              ),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  FloatingActionButton.extended(
                    onPressed: () {
                      //score.setUserName(myController.text);
                      player.setName(myController.text);
                      if (isUserTakePicture) {
                        //score.setUserName(myController.text);
                        //print(score.getUserName());

                        Navigator.push(
                          context,
                          MaterialPageRoute(
                              builder: (context) => JsonTest(player)),
                        );
                      } else {
                        setState(() {
                          //createPlayer(myController.text);
                          _showDialog();
                        });
                      }
                    },
                    label: Text(LocaleKeys.start_quiz_button.tr()),
                    icon: const Icon(Icons.thumb_up),
                    backgroundColor: Colors.green,
                  ),
                  FloatingActionButton(
                    backgroundColor: Colors.blue,
                    onPressed: getImage,
                    child: Icon(
                      Icons.camera_alt_outlined,
                      size: 24,
                      //semanticLabel: 'Text to announce in accessibility modes',
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }
}
