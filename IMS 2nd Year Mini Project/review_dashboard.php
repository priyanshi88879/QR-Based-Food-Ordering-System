<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Food Review & Rating</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-xl p-6">

    <!-- Title -->
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
        ⭐ Rate Your Food Experience
    </h1>


    <!-- Reviews List -->
    <div class="bg-white p-6 rounded-xl shadow-lg mt-8">
        <h2 class="text-xl font-semibold mb-4">Customer Reviews</h2>

        <div id="reviewsList" class="space-y-4">
            Loading reviews...
        </div>
    </div>

</div>

<script>
function loadReviews() {
    fetch("get_reviews.php")
    .then(res => res.json())
    .then(data => {
        const box = document.getElementById("reviewsList");

        if (data.length === 0) {
            box.innerHTML = "<p class='text-gray-500'>No reviews yet.</p>";
            return;
        }

        box.innerHTML = data.map(r => `
            <div class="p-4 bg-gray-50 rounded-lg border">
                <div class="flex justify-between">
                    <span class="font-semibold">${r.username}</span>
                    <span class="text-yellow-500">${"⭐".repeat(r.rating)}</span>
                </div>
                <p class="text-gray-700 mt-1">${r.comment}</p>
                <p class="text-gray-400 text-sm mt-1">${r.created_at}</p>
            </div>
        `).join("");
    });
}

function submitReview() {
    let username = document.getElementById("username").value.trim();
    let rating = document.getElementById("rating").value;
    let comment = document.getElementById("comment").value.trim();

    if (username === "" || comment === "") {
        alert("Please fill all fields!");
        return;
    }

    fetch("add_review.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({username, rating, comment})
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        loadReviews();

        // Clear fields
        document.getElementById("username").value = "";
        document.getElementById("comment").value = "";
    });
}

loadReviews();
</script>

</body>
</html>
