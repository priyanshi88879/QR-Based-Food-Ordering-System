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

    <!-- Review Form -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Leave a Review</h2>

        <label class="block font-medium mb-1">Your Name</label>
        <input id="username" type="text" class="w-full border p-2 rounded mb-4" placeholder="Your Name">

        <label class="block font-medium mb-1">Rating</label>
        <div class="flex gap-2 mb-4">
            <select id="rating" class="w-full border p-2 rounded">
                <option value="5">⭐ 5 - Excellent</option>
                <option value="4">⭐ 4 - Good</option>
                <option value="3">⭐ 3 - Average</option>
                <option value="2">⭐ 2 - Poor</option>
                <option value="1">⭐ 1 - Very Bad</option>
            </select>
        </div>

        <label class="block font-medium mb-1">Write Review</label>
        <textarea id="comment" rows="4" class="w-full border p-2 rounded mb-4" placeholder="Share your experience..."></textarea>

        <button onclick="submitReview()" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
            Submit Review
        </button>
    </div>

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
