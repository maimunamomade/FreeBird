<?php

if ($reason == "order") {

	echo "has just sent you an order.";
}

if ($reason == "order_message") {

	echo "message related to your order.";
}

if ($reason == "order_revision") {

	echo "requested revision on your order.";
}


if ($reason == "order_completed") {

	echo "completed your order.";
}


if ($reason == "order_delivered") {

	echo "your order has been delivered.";
}


if ($reason == "cancellation_request") {

	echo "order update, cancellation request was  sent.";
}


if ($reason == "decline_cancellation_request") {

	echo "your cancellation request was declined.";
}



if ($reason == "accept_cancellation_request") {

	echo "your cancellation request was accepted, and your order has been cancelled.";
}



if ($reason == "cancelled_by_customer_support") {

	echo "website customer support has cancelled your order.";
}


if ($reason == "buyer_order_review") {

	echo "your order was updated. review and rate the work.";
}


if ($reason == "seller_order_review") {

	echo "your order was updated, and reviewed.";
}


if ($reason == "order_cancelled") {

	echo "your order has been cancelled.";
}


 