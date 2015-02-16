var recognition;

var nowRecognition = false;

function start () {
    recognition = new webkitSpeechRecognition();
    recognition.lang = 'ja-JP'; // en-US or ja-JP
    recognition.onresult = function (e) {
        if (e.results.length > 0) {
            var value = e.results[0][0].transcript;
            document.querySelector('#misaka_speech_area').textContent = value;
        }
    };
    recognition.start();
    nowRecognition = true;
};

function stop () {
    recognition.stop();
    nowRecognition = false;
}

document.querySelector('#misaka_shiromu').onclick = function () {
    if (!'webkitSpeechRecognition' in window) {
        alert('Web Speech API には未対応です.');
        return;
    }

    if (nowRecognition) {
        stop();
        this.value = '音声認識を始める';
        this.className = '';
    } else {
        start();
        this.value = '音声認識を止める';
        this.className = 'select';
    }
}