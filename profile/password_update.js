document.addEventListener("DOMContentLoaded", () => {
    console.log("Password update script loaded.");
    const form = document.getElementById("updatePasswordForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("profile/update_password.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);

            if (data.status === "success") {
                form.reset(); // Clear form
                window.location = "index.php?page=profile/view";
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Something went wrong. Please try again.");
        });
    });
});
