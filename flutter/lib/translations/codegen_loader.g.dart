// DO NOT EDIT. This is code generated via package:easy_localization/generate.dart

// ignore_for_file: prefer_single_quotes

import 'dart:ui';

import 'package:easy_localization/easy_localization.dart' show AssetLoader;

class CodegenLoader extends AssetLoader{
  const CodegenLoader();

  @override
  Future<Map<String, dynamic>> load(String fullPath, Locale locale ) {
    return Future.value(mapLocales[locale.toString()]);
  }

  static const Map<String,dynamic> en = {
  "welcome_text": "Welcom Quizz App ",
  "enter_yourName": "Enter Your Name",
  "start_quiz_button": "Start Quiz",
  "no_photo": "no_photo",
  "please_take_photo": "please take your own phot to start exam"
};
static const Map<String,dynamic> tr = {
  "welcome_text": "Quiz Uygulamasına Hoş Geldiniz ",
  "enter_yourName": "İsminizi Giriniz",
  "start_quiz_button": "Quize Başla",
  "no_photo": "Fotograf Yüklemediniz",
  "please_take_photo": "Lütfen Fotoğrafınızı Çekiniz"
};
static const Map<String, Map<String,dynamic>> mapLocales = {"en": en, "tr": tr};
}
