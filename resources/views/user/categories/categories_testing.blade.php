<!DOCTYPE html>
<html>

<head>
    <title>Page Title</title>
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .product-card {
        width: 350px;
        /* Set your desired card width */
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        margin: 20px;
    }

    .image-container {
        width: 100%;
        aspect-ratio: 7 / 4.3;
        /* Creates a perfect landscape box (wider than tall) */
        background-color: #f5f5f5;
        /* Fills empty space if you switch to 'contain' */
        overflow: hidden;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Fills the landscape box completely without stretching */
        object-position: center;
        /* Keeps the product centered */
        border-radius: 8px 8px 0px 0px;
    }

    .product-info {
        color: navy;
        padding: 11px 10px;
        font-weight: 500;
    }

    .product-info button {
        padding: 10px 20px;
        background-color: navy;
        color: white;
        border: none;
        width: 100%;
        border-radius: 8px;
    }

    .amount {
        display: flex;
        gap: 8px;
        padding: 10px 0px;
        font-size: 20px;
        align-items: end;
    }

    .prev-amount {
        font-size: 12px;
        text-decoration: line-through;
        color: gray;
    }
</style>

<body>

    <div class="product-card">
        <div class="image-container">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSXWBj0z6Yr-k4IBzHMY6WXBoIQkJ-ruTopPSnoojFKGhYH6pkt0ybkS3c&s=10"
                alt="Product Image">
        </div>
        <div class="product-info">
            <h3>Product Title</h3>
            <div class="amount">
                <p>PKR 49.99</p>
                <p class="prev-amount">PKR 222</p>
            </div>
            <button>Add TO Cart</button>
        </div>
    </div>

</body>

</html>