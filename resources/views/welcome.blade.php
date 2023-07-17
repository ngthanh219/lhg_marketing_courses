<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
</head>
<body>
    Welcome
    <br>
    <video id="videoData" controls controlsList="nodownload">
        <source id="videoSource" src="{{ $video }}" type="video/mp4">
    </video>
</body>
</html>
<script type="text/javascript">
    setTimeout(() => {
        const videoSourceEle = document.getElementById("videoSource");
        videoSourceEle.removeAttribute("src");

        // const currentControlsList = videoDataEle.getAttribute("controlsList");
        // console.log(videoDataEle);

        // if (currentControlsList.includes("nodownload")) {
        //     // Xóa tùy chọn nodownload
        //     const newControlsList = currentControlsList.replace("nodownload", "").trim();
        //     videoDataEle.setAttribute("controlsList", newControlsList);
        // } else {
        //     // Thêm tùy chọn nodownload
        //     const newControlsList = `${currentControlsList} nodownload`.trim();
        //     videoDataEle.setAttribute("controlsList", newControlsList);
        // }
    }, 1000);

    window.addEventListener('orientationchange', function() {
        // Xử lý logic khi hướng màn hình thay đổi
        console.log("Màn hình thay đổi");
    });

    document.addEventListener("visibilitychange", function() {
        if (document.visibilityState === "visible") {
            // console.log("Tab được chọn");
        } else {
            console.log("Tab không được chọn");
        }
    });

    document.addEventListener("mouseout", function(event) {
        if (event.clientY <= 0 || event.clientX <= 0 || (event.clientX + 10 >= window.innerWidth || event.clientY + 10 >= window.innerHeight)) {
            console.log("Chuột đã rời khỏi trang");
        }
    });

    document.addEventListener("mouseleave", function() {
        console.log("Chuột đã đi ra khỏi khung hình web");
    });

    document.addEventListener('keydown', function(event) {
        // const pressedKey = event.key;
        // console.log('Pressed key:', pressedKey);

        // if (count >= 2) {
        //     console.log('Đã ra tab khác');
        // } else {
        //     if (event.key == 'Alt') {
        //         count++;

        //         if (event.key === 'Tab') {
        //             count++;
        //         }
        //     }
        // }
        if (event.key === "F12") {
            console.log('F12');
        }
        if (event.key === "F12" || event.keyCode === 123) {
            event.preventDefault();
        }
    });

    // Chuột phải
    // document.addEventListener("contextmenu", function(event) {
    //     event.preventDefault();
    // });
</script>
