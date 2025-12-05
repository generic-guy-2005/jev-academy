document.addEventListener("DOMContentLoaded", () => {
    console.log("User delete script loaded");
    const deleteButtons = document.querySelectorAll(".deleteUser");

    deleteButtons.forEach(btn => {
        // btn.addEventListener("click", () => {
        //     const userID = btn.getAttribute("data-id");

        //     if (!confirm("Are you sure you want to delete this user?")) return;

        //     fetch("backend/user_delete.php", {
        //         method: "POST",
        //         headers: {
        //             "Content-Type": "application/x-www-form-urlencoded"
        //         },
        //         body: "id=" + userID
        //     })
        //         .then(response => response.text())
        //         .then(res => {
        //             if (res === "success") {
        //                 alert("User deleted successfully.");
        //                 location.reload();
        //             } else {
        //                 alert("Failed to delete user.");
        //             }
        //         });
        //     });

        const currentUserID = new URLSearchParams(window.location.search).get('id');
        if (currentUserID) {
            fetch("backend/user_delete.php?id=" + currentUserID, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            })
                .then(response => response.text())
                .then(res => {
                    if (res === "success") {
                        alert("User deleted successfully.");
                        location.reload();
                    } else {
                        alert("Failed to delete user.");
                    }
                });
        }
    });
});