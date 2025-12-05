document.getElementById('updateProfileForm').addEventListener('submit', function (e) {
    console.log("Update profile form submitted");
    e.preventDefault();

    let formData = new FormData(this);

    fetch('profile/update_profile.php', {
        method: "POST",
        body: formData
    })
        .then(res => res.text())
        .then(res => {
            if (res === "success") {
                alert("Profile updated!");
                location.href = "index.php?page=profile/view";
            } else {
                alert("Update failed: " + res);
            }
        });
});
