$(function(){

        console.log("Loading Strings!");
        function loadString() {
                $.getJSON("/api/students/", function(students) {
                        console.log(students);
                        var message = "Nobody is here";
                        if (students.length > 2) {
                                message = students[3].cluster + "\n " + students[3].string + ", taille: " + students[3].length;
                        }
                        $(".myClass").text(message);
                });
        };

        loadString();
        setInterval(loadString, 2000);
});
