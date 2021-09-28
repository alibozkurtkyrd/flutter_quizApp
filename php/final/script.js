var question_options = document.getElementById('question_options');
var add_more_fields = document.getElementById('add_more_fields');
var remove_fields = document.getElementById('remove_fields');



add_more_fields.onclick = function(){

    var newField = document.createElement('input');
    newField.setAttribute('type', 'text');
    newField.setAttribute('name','question_options[]');
    newField.setAttribute('class', 'question_options');
    newField.setAttribute('siz',50);
    newField.setAttribute('placeholder','add an option');
    question_options.appendChild(newField);
}

remove_fields.onclick = function(){
    var input_tags = question_options.getElementsByTagName('input');
    if (input_tags.length>1){
        question_options.removeChild(input_tags[(input_tags.length)-1]);
    }
}

