import 'dart:io';

import 'package:flutter/cupertino.dart';

class Player {
  String name;
  int point;
  int completion_time; // oyunun bitme zamanı
  static File image;
  DateTime now;
  String country = WidgetsBinding.instance.window.locale.countryCode;

  void setName(String name) {
    this.name = name;
  }

  String getName() {
    return this.name;
  }

  void setPoint(int point) {
    this.point = point;
  }

  int getPoint() {
    return this.point;
  }

  void setCompletionTime(int completiton_time) {
    this.completion_time = completiton_time;
  }

  int getCompletionTime() {
    return this.completion_time;
  }

  void setImage(File img) {
    image = img;
  }

  File getImage() {
    return image;
  }

  void setNow(DateTime time) {
    this.now = time;
  }

  DateTime getNow() {
    return this.now;
  }

  void setCountry(String country) {
    this.country = country;
  }

  String getCountry() {
    return this.country;
  }


}
