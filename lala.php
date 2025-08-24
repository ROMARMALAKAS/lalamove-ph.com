<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lalamove - On-Demand Delivery Service Philippines</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .lalamove-gradient {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
        }
        .card-shadow {
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .booking-card {
            transition: all 0.3s ease;
        }
        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        .status-approved {
            background-color: #dcfce7;
            color: #16a34a;
        }
        .status-rider-assigned {
            background-color: #e0e7ff;
            color: #4338ca;
        }
        .status-rider-otw {
            background-color: #dbeafe;
            color: #2563eb;
        }
        .status-delivered {
            background-color: #dcfce7;
            color: #16a34a;
        }
        .status-cancelled {
            background-color: #fee2e2;
            color: #dc2626;
        }
        .nav-item {
            transition: all 0.3s ease;
        }
        .nav-item:hover {
            transform: translateY(-2px);
        }
        .progress-bar {
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #ff6b35, #f7931e);
            transition: width 0.5s ease;
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }
        .notification.show {
            transform: translateX(0);
        }
        .modal-backdrop {
            backdrop-filter: blur(4px);
        }
        .tracking-line {
            position: relative;
        }
        .tracking-line::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
        }
        .tracking-step {
            position: relative;
            padding-left: 40px;
        }
        .tracking-step.completed::before {
            background-color: #16a34a;
        }
        .tracking-step.current::before {
            background-color: #ff6b35;
        }
        .tracking-icon {
            position: absolute;
            left: 8px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
        }
        .tracking-icon.completed {
            background-color: #16a34a;
            color: white;
        }
        .tracking-icon.current {
            background-color: #ff6b35;
            color: white;
            animation: pulse 2s infinite;
        }
        .tracking-icon.pending {
            background-color: #e5e7eb;
            border: 2px solid #9ca3af;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .eta-badge {
            background: linear-gradient(45deg, #ff6b35, #f7931e);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Notification -->
    <div id="notification" class="notification bg-white rounded-lg shadow-lg border border-gray-200 p-4">
        <div class="flex items-center space-x-3">
            <div id="notificationIcon" class="w-10 h-10 rounded-full flex items-center justify-center">
                <i class="fas fa-info-circle text-xl"></i>
            </div>
            <div class="flex-1">
                <p id="notificationTitle" class="font-semibold text-gray-900"></p>
                <p id="notificationMessage" class="text-sm text-gray-600"></p>
            </div>
            <button onclick="hideNotification()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="lalamove-gradient text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-truck-fast text-2xl"></i>
                    <h1 class="text-2xl font-bold">Lalamove</h1>
                </div>
                <div class="hidden md:flex space-x-6">
                    <button onclick="showSection('home')" class="nav-item hover:text-yellow-300 font-medium">
                        <i class="fas fa-home mr-2"></i>Home
                    </button>
                    <button onclick="showSection('booking')" class="nav-item hover:text-yellow-300 font-medium">
                        <i class="fas fa-plus-circle mr-2"></i>New Booking
                    </button>
                    <button onclick="showSection('dashboard')" class="nav-item hover:text-yellow-300 font-medium">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </button>
                    <button onclick="showSection('track')" class="nav-item hover:text-yellow-300 font-medium">
                        <i class="fas fa-map-marker-alt mr-2"></i>Track Order
                    </button>
                </div>
                <div class="md:hidden">
                    <button onclick="toggleMobileMenu()" class="text-white">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-orange-600">
            <div class="px-4 py-2 space-y-2">
                <button onclick="showSection('home')" class="block w-full text-left py-2 hover:bg-orange-700 rounded px-2">
                    <i class="fas fa-home mr-2"></i>Home
                </button>
                <button onclick="showSection('booking')" class="block w-full text-left py-2 hover:bg-orange-700 rounded px-2">
                    <i class="fas fa-plus-circle mr-2"></i>New Booking
                </button>
                <button onclick="showSection('dashboard')" class="block w-full text-left py-2 hover:bg-orange-700 rounded px-2">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </button>
                <button onclick="showSection('track')" class="block w-full text-left py-2 hover:bg-orange-700 rounded px-2">
                    <i class="fas fa-map-marker-alt mr-2"></i>Track Order
                </button>
            </div>
        </div>
    </nav>

    <!-- Home Section -->
    <section id="homeSection" class="animate-fade-in">
        <!-- Hero Section -->
        <div class="lalamove-gradient text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <h2 class="text-5xl font-bold leading-tight">Fast, Reliable Delivery in the Philippines</h2>
                        <p class="text-xl text-gray-100">Get your items delivered quickly and safely across Metro Manila and major cities. Professional riders at your service 24/7.</p>
                        <div class="space-x-4">
                            <button onclick="showSection('booking')" class="bg-white text-orange-600 px-8 py-3 rounded-lg font-semibold transition duration-300 hover:bg-gray-100">
                                Book Now
                            </button>
                            <button onclick="showSection('track')" class="border-2 border-white hover:bg-white hover:text-orange-600 px-8 py-3 rounded-lg font-semibold transition duration-300">
                                Track Order
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/83151b70-b781-44ea-bd71-9ae42d16ab42.png" alt="Professional Lalamove delivery rider on motorcycle with orange delivery bag in Manila streets, wearing safety helmet and orange Lalamove uniform, modern Philippine cityscape in background" class="rounded-lg shadow-xl" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Lalamove?</h3>
                    <p class="text-lg text-gray-600">Experience the best delivery service in the Philippines</p>
                </div>
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clock text-2xl text-orange-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Fast Delivery</h4>
                        <p class="text-gray-600">Quick pickup and delivery within Metro Manila.</p>
                    </div>
                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-map-marker-alt text-2xl text-blue-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Real-time Tracking</h4>
                        <p class="text-gray-600">Track your delivery in real-time with GPS.</p>
                    </div>
                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt text-2xl text-green-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">Safe & Secure</h4>
                        <p class="text-gray-600">Your items are insured and handled with care.</p>
                    </div>
                    <div class="text-center p-6 rounded-lg hover:shadow-lg transition duration-300">
                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-headset text-2xl text-purple-600"></i>
                        </div>
                        <h4 class="text-xl font-semibold mb-2">24/7 Support</h4>
                        <p class="text-gray-600">Round-the-clock customer support.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="py-16 lalamove-gradient text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold mb-2" id="deliveryCount">0</div>
                        <div class="text-lg">Successful Deliveries</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">1000+</div>
                        <div class="text-lg">Active Riders</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">24/7</div>
                        <div class="text-lg">Service Available</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold mb-2">4.9★</div>
                        <div class="text-lg">Customer Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section id="bookingSection" class="hidden py-16 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Create New Delivery Booking</h2>
                <p class="text-lg text-gray-600">Fill out the form below to schedule your delivery</p>
            </div>

            <div class="bg-white rounded-xl shadow-xl p-8">
                <form id="bookingForm" class="space-y-6">
                    <!-- Item Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                            <i class="fas fa-box mr-2 text-orange-600"></i>
                            Item Information
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                                <input type="text" id="itemName" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-300" placeholder="e.g., Documents, Food, Electronics">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Item Category</label>
                                <select id="itemCategory" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-300">
                                    <option value="">Select Category</option>
                                    <option value="documents">Documents</option>
                                    <option value="food">Food & Beverages</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="clothing">Clothing</option>
                                    <option value="medicine">Medicine</option>
                                    <option value="grocery">Grocery</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Item Description</label>
                            <textarea id="itemDescription" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-300" placeholder="Describe your item (optional)"></textarea>
                        </div>
                    </div>

                    <!-- Pickup & Delivery Information -->
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                            Pickup & Delivery Information
                        </h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Pickup Information -->
                            <div>
                                <h4 class="font-medium text-gray-700 mb-3">Pickup Details</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Address</label>
                                        <textarea id="pickupAddress" required rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Complete pickup address"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
                                        <input type="text" id="pickupContact" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Full name">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" id="pickupPhone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="+63 917 123 4567">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Delivery Information -->
                            <div>
                                <h4 class="font-medium text-gray-700 mb-3">Delivery Details</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Address</label>
                                        <textarea id="deliveryAddress" required rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Complete delivery address"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Recipient Name</label>
                                        <input type="text" id="recipientName" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="Full name">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" id="recipientPhone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300" placeholder="+63 928 987 6543">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 flex items-center">
                            <i class="fas fa-peso-sign mr-2 text-green-600"></i>
                            Shipping Information
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Distance (km)</label>
                                <input type="number" id="distance" min="0" step="0.1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300" placeholder="Enter distance in kilometers">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Fee (₱)</label>
                                <input type="number" id="shippingFee" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300" placeholder="Enter shipping fee amount">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Special Instructions</label>
                            <textarea id="specialInstructions" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-300" placeholder="Any special delivery instructions (optional)"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center pt-6">
                        <button type="submit" class="lalamove-gradient text-white px-8 py-3 rounded-lg font-semibold text-lg hover:opacity-90 transition duration-300 transform hover:scale-105">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Booking Request
                        </button>
                        <p class="text-sm text-gray-500 mt-2">Your booking will be reviewed and approved by our team</p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Dashboard Section -->
    <section id="dashboardSection" class="hidden py-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Admin Dashboard</h2>
                <p class="text-lg text-gray-600">Manage and approve delivery bookings</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid md:grid-cols-6 gap-4 mb-8">
                <div class="bg-white p-4 rounded-lg card-shadow text-center">
                    <div class="bg-yellow-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div class="text-xl font-bold text-gray-900" id="pendingCount">0</div>
                    <div class="text-xs text-gray-600">Pending</div>
                </div>
                <div class="bg-white p-4 rounded-lg card-shadow text-center">
                    <div class="bg-green-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div class="text-xl font-bold text-gray-900" id="approvedCount">0</div>
                    <div class="text-xs text-gray-600">Approved</div>
                </div>
                <div class="bg-white p-4 rounded-lg card-shadow text-center">
                    <div class="bg-purple-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-user-check text-purple-600"></i>
                    </div>
                    <div class="text-xl font-bold text-gray-900" id="assignedCount">0</div>
                    <div class="text-xs text-gray-600">Assigned</div>
                </div>
                <div class="bg-white p-4 rounded-lg card-shadow text-center">
                    <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-motorcycle text-blue-600"></i>
                    </div>
                    <div class="text-xl font-bold text-gray-900" id="otwCount">0</div>
                    <div class="text-xs text-gray-600">On The Way</div>
                </div>
                <div class="bg-white p-4 rounded-lg card-shadow text-center">
                    <div class="bg-emerald-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-check-double text-emerald-600"></i>
                    </div>
                    <div class="text-xl font-bold text-gray-900" id="deliveredCount">0</div>
                    <div class="text-xs text-gray-600">Delivered</div>
                </div>
                <div class="bg-white p-4 rounded-lg card-shadow text-center">
                    <div class="bg-orange-100 w-10 h-10 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-peso-sign text-orange-600"></i>
                    </div>
                    <div class="text-xl font-bold text-gray-900" id="totalEarnings">₱0.00</div>
                    <div class="text-xs text-gray-600">Earnings</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-4">
                    <button onclick="autoAssignRiders()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-magic mr-2"></i>Auto Assign Available Riders
                    </button>
                    <button onclick="simulateRiderMovement()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-play mr-2"></i>Simulate Rider Movement
                    </button>
                    <button onclick="markAllDelivered()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        <i class="fas fa-check-double mr-2"></i>Mark All OTW as Delivered
                    </button>
                </div>
            </div>

            <!-- Bookings List -->
            <div class="bg-white rounded-xl shadow-xl">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">All Bookings</h3>
                    <div class="flex space-x-2">
                        <select id="statusFilter" onchange="filterBookings()" class="px-3 py-1 border border-gray-300 rounded text-sm">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rider-assigned">Rider Assigned</option>
                            <option value="rider-otw">On The Way</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <button onclick="clearAllBookings()" class="text-red-600 hover:text-red-800 font-medium text-sm">
                            <i class="fas fa-trash mr-1"></i>Clear All
                        </button>
                    </div>
                </div>
                <div id="bookingsList" class="p-6">
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-inbox text-4xl mb-4"></i>
                        <p class="text-lg">No bookings yet. Create your first booking to get started!</p>
                        <button onclick="showSection('booking')" class="mt-4 lalamove-gradient text-white px-6 py-2 rounded-lg hover:opacity-90 transition duration-300">
                            Create Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Track Order Section -->
    <section id="trackSection" class="hidden py-16 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Track Your Order</h2>
                <p class="text-lg text-gray-600">Enter your booking ID to track your delivery in real-time</p>
            </div>

            <!-- Track Input -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex space-x-4">
                    <input type="text" id="trackingInput" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="Enter your Booking ID (e.g., 1234567890123)">
                    <button onclick="trackOrder()" class="lalamove-gradient text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition duration-300">
                        <i class="fas fa-search mr-2"></i>Track
                    </button>
                </div>
            </div>

            <!-- Tracking Results -->
            <div id="trackingResults" class="hidden">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div id="trackingHeader" class="lalamove-gradient text-white p-6">
                        <!-- Tracking header will be populated by JavaScript -->
                    </div>
                    <div class="p-6">
                        <div id="trackingContent" class="space-y-6">
                            <!-- Tracking content will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6 mt-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Orders</h3>
                <div id="recentOrders" class="space-y-3">
                    <!-- Recent orders will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </section>

    <!-- Modals -->
    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-white rounded-lg p-8 max-w-md mx-4 text-center">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-2xl text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold mb-2">Booking Submitted Successfully!</h3>
            <p class="text-gray-600 mb-4">Your delivery booking has been submitted and is awaiting approval.</p>
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <p class="text-sm text-gray-700">
                    <strong>Booking ID:</strong> <span id="bookingId" class="font-mono"></span>
                </p>
                <p class="text-xs text-gray-500 mt-2">Save this ID to track your order</p>
            </div>
            <div class="space-x-3">
                <button onclick="closeModal('successModal')" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg transition duration-300">
                    Close
                </button>
                <button onclick="closeModal('successModal'); showSection('track')" class="lalamove-gradient text-white px-4 py-2 rounded-lg hover:opacity-90 transition duration-300">
                    Track Order
                </button>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-white rounded-lg p-8 max-w-md mx-4">
            <div class="text-center mb-6">
                <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-times text-2xl text-red-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Cancel Booking</h3>
                <p class="text-gray-600">Please provide a reason for cancelling this booking:</p>
            </div>
            <form id="rejectForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cancellation Reason</label>
                    <select id="rejectionReason" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-300 mb-2">
                        <option value="">Select a reason</option>
                        <option value="Invalid address">Invalid or incomplete address</option>
                        <option value="Unsafe item">Item not allowed for delivery</option>
                        <option value="Insufficient information">Insufficient booking information</option>
                        <option value="High risk delivery">High risk delivery area</option>
                        <option value="No available riders">No available riders for this route</option>
                        <option value="Customer request">Customer cancellation request</option>
                        <option value="Other">Other (specify below)</option>
                    </select>
                    <textarea id="rejectionMessage" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-300" placeholder="Additional details (optional)"></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="closeModal('rejectModal')" class="flex-1 bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg transition duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        Cancel Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Details Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-white rounded-lg p-8 max-w-3xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-900">Booking Details</h3>
                <button onclick="closeModal('detailsModal')" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="detailsContent">
                <!-- Details content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <!-- Assign Rider Modal -->
    <div id="assignRiderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 modal-backdrop">
        <div class="bg-white rounded-lg p-8 max-w-md mx-4">
            <div class="text-center mb-6">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-motorcycle text-2xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Assign Rider</h3>
                <p class="text-gray-600">Select a rider for this delivery:</p>
            </div>
            <form id="assignRiderForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Available Riders</label>
                    <select id="availableRiders" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        <option value="">Select a rider</option>
                    </select>
                </div>
                <div class="flex space-x-3">
                    <button type="button" onclick="closeModal('assignRiderModal')" class="flex-1 bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-lg transition duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        Assign Rider
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize app
        let bookings = JSON.parse(localStorage.getItem('lalamoveBookings')) || [];
        let riders = JSON.parse(localStorage.getItem('lalamoveRiders')) || [
            { id: '1', name: 'Juan Miguel Santos', phone: '+63 917 123 4567', picture: 'https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/af34d0f3-1967-44be-82a6-6e68d9be1308.png', status: 'available', rating: 4.8 },
            { id: '2', name: 'Maria Elena Cruz', phone: '+63 928 234 5678', picture: 'https://placehold.co/100x100', status: 'available', rating: 4.9 },
            { id: '3', name: 'Jose Carlo Reyes', phone: '+63 939 345 6789', picture: 'https://placehold.co/100x100', status: 'available', rating: 4.7 },
            { id: '4', name: 'Anna Marie Gonzales', phone: '+63 946 456 7890', picture: 'https://placehold.co/100x100', status: 'available', rating: 4.8 },
            { id: '5', name: 'Mark Anthony Dela Cruz', phone: '+63 955 567 8901', picture: 'https://placehold.co/100x100', status: 'available', rating: 4.6 }
        ];
        let currentSection = 'home';
        let currentBookingId = null;

        // Save riders to localStorage
        localStorage.setItem('lalamoveRiders', JSON.stringify(riders));

        // Navigation functions
        function showSection(section) {
            // Hide all sections
            document.getElementById('homeSection').classList.add('hidden');
            document.getElementById('bookingSection').classList.add('hidden');
            document.getElementById('dashboardSection').classList.add('hidden');
            document.getElementById('trackSection').classList.add('hidden');
            
            // Show selected section
            document.getElementById(section + 'Section').classList.remove('hidden');
            currentSection = section;
            
            // Close mobile menu
            document.getElementById('mobileMenu').classList.add('hidden');
            
            // Refresh dashboard if showing
            if (section === 'dashboard') {
                refreshDashboard();
            } else if (section === 'track') {
                loadRecentOrders();
            }
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Handle form submission
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Generate unique booking ID
            const bookingId = Date.now().toString();
            
            // Get form data
            const formData = {
                id: bookingId,
                itemName: document.getElementById('itemName').value,
                itemCategory: document.getElementById('itemCategory').value,
                itemDescription: document.getElementById('itemDescription').value,
                pickupAddress: document.getElementById('pickupAddress').value,
                pickupContact: document.getElementById('pickupContact').value,
                pickupPhone: document.getElementById('pickupPhone').value,
                deliveryAddress: document.getElementById('deliveryAddress').value,
                recipientName: document.getElementById('recipientName').value,
                recipientPhone: document.getElementById('recipientPhone').value,
                shippingFee: parseFloat(document.getElementById('shippingFee').value),
                distance: parseFloat(document.getElementById('distance').value),
                specialInstructions: document.getElementById('specialInstructions').value,
                status: 'pending',
                createdAt: new Date().toISOString(),
                estimatedDelivery: calculateEstimatedDelivery(),
                statusHistory: [{
                    status: 'pending',
                    timestamp: new Date().toISOString(),
                    message: 'Booking submitted and awaiting approval'
                }]
            };

            // Save to bookings
            bookings.unshift(formData);
            localStorage.setItem('lalamoveBookings', JSON.stringify(bookings));

            // Show booking ID in success modal
            document.getElementById('bookingId').textContent = bookingId;

            // Reset form
            document.getElementById('bookingForm').reset();

            // Show success modal
            document.getElementById('successModal').classList.remove('hidden');

            // Show notification
            showNotification('Booking Submitted', 'Your booking has been submitted successfully!', 'success');
        });

        // Handle reject form submission
        document.getElementById('rejectForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const reason = document.getElementById('rejectionReason').value;
            const message = document.getElementById('rejectionMessage').value;
            
            const fullMessage = message ? `${reason}: ${message}` : reason;
            
            updateBookingStatus(currentBookingId, 'cancelled', fullMessage);
            closeModal('rejectModal');
            
            // Reset form
            document.getElementById('rejectForm').reset();
        });

        // Handle assign rider form submission
        document.getElementById('assignRiderForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const riderId = document.getElementById('availableRiders').value;
            const rider = riders.find(r => r.id === riderId);
            
            if (rider) {
                assignRiderToBooking(currentBookingId, rider);
                closeModal('assignRiderModal');
            }
        });

        function calculateEstimatedDelivery() {
            const now = new Date();
            const minutes = 45 + Math.random() * 30; // 45-75 minutes
            const estimated = new Date(now.getTime() + minutes * 60000);
            return estimated.toISOString();
        }

        function updateBookingStatus(bookingId, newStatus, message = null) {
            const bookingIndex = bookings.findIndex(b => b.id === bookingId);
            if (bookingIndex !== -1) {
                const booking = bookings[bookingIndex];
                const oldStatus = booking.status;
                booking.status = newStatus;
                
                // Add to status history
                const statusMessage = message || getStatusMessage(newStatus);
                booking.statusHistory.push({
                    status: newStatus,
                    timestamp: new Date().toISOString(),
                    message: statusMessage
                });

                if (newStatus === 'cancelled' && message) {
                    booking.cancellationReason = message;
                    booking.cancelledAt = new Date().toISOString();
                } else if (newStatus === 'approved') {
                    booking.approvedAt = new Date().toISOString();
                } else if (newStatus === 'rider-assigned') {
                    booking.riderAssignedAt = new Date().toISOString();
                } else if (newStatus === 'rider-otw') {
                    booking.riderOtwAt = new Date().toISOString();
                    booking.estimatedArrival = new Date(Date.now() + (20 + Math.random() * 20) * 60000).toISOString();
                } else if (newStatus === 'delivered') {
                    booking.deliveredAt = new Date().toISOString();
                }

                localStorage.setItem('lalamoveBookings', JSON.stringify(bookings));
                
                if (currentSection === 'dashboard') {
                    refreshDashboard();
                }

                // Show notification for status change
                showNotification('Status Updated', `Booking ${bookingId} is now ${newStatus.replace('-', ' ')}`, 'info');
            }
        }

        function getStatusMessage(status) {
            const messages = {
                'pending': 'Booking submitted and awaiting approval',
                'approved': 'Booking approved by admin',
                'rider-assigned': 'Rider has been assigned to your booking',
                'rider-otw': 'Rider is on the way to pickup location',
                'delivered': 'Package has been successfully delivered',
                'cancelled': 'Booking has been cancelled'
            };
            return messages[status] || 'Status updated';
        }

        function approveBooking(bookingId) {
            if (confirm('Are you sure you want to approve this booking?')) {
                updateBookingStatus(bookingId, 'approved');
            }
        }

        function rejectBooking(bookingId) {
            currentBookingId = bookingId;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function assignRider(bookingId) {
            currentBookingId = bookingId;
            
            // Populate available riders
            const availableRiders = riders.filter(r => r.status === 'available');
            const select = document.getElementById('availableRiders');
            select.innerHTML = '<option value="">Select a rider</option>';
            
            availableRiders.forEach(rider => {
                const option = document.createElement('option');
                option.value = rider.id;
                option.textContent = `${rider.name} (⭐ ${rider.rating})`;
                select.appendChild(option);
            });
            
            document.getElementById('assignRiderModal').classList.remove('hidden');
        }

        function assignRiderToBooking(bookingId, rider) {
            const bookingIndex = bookings.findIndex(b => b.id === bookingId);
            if (bookingIndex !== -1) {
                // Update booking with rider info
                bookings[bookingIndex].riderId = rider.id;
                bookings[bookingIndex].riderName = rider.name;
                bookings[bookingIndex].riderPhone = rider.phone;
                bookings[bookingIndex].riderPicture = rider.picture;
                bookings[bookingIndex].riderRating = rider.rating;
                
                // Update rider status
                const riderIndex = riders.findIndex(r => r.id === rider.id);
                if (riderIndex !== -1) {
                    riders[riderIndex].status = 'busy';
                    riders[riderIndex].currentBooking = bookingId;
                    localStorage.setItem('lalamoveRiders', JSON.stringify(riders));
                }
                
                updateBookingStatus(bookingId, 'rider-assigned');
                
                // Automatically progress to OTW after 10 seconds
                setTimeout(() => {
                    updateBookingStatus(bookingId, 'rider-otw');
                }, 10000);
            }
        }

        function trackOrder() {
            const bookingId = document.getElementById('trackingInput').value.trim();
            if (!bookingId) {
                showNotification('Error', 'Please enter a booking ID', 'error');
                return;
            }

            const booking = bookings.find(b => b.id === bookingId);
            if (!booking) {
                showNotification('Not Found', 'Booking ID not found', 'error');
                document.getElementById('trackingResults').classList.add('hidden');
                return;
            }

            displayTrackingResults(booking);
        }

        function displayTrackingResults(booking) {
            const resultsDiv = document.getElementById('trackingResults');
            const headerDiv = document.getElementById('trackingHeader');
            const contentDiv = document.getElementById('trackingContent');

            // Header
            headerDiv.innerHTML = `
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">${booking.itemName}</h3>
                        <p class="text-orange-100">Booking ID: ${booking.id}</p>
                        <p class="text-orange-100">₱${booking.shippingFee.toFixed(2)} • ${booking.distance}km</p>
                    </div>
                    <span class="status-badge status-${booking.status} bg-white bg-opacity-20 text-white border border-white">
                        <i class="fas fa-${getStatusIcon(booking.status)} mr-1"></i>
                        ${booking.status.replace('-', ' ').toUpperCase()}
                    </span>
                </div>
            `;

            // Progress bar
            const progress = getProgressPercentage(booking.status);
            
            // ETA
            let etaHtml = '';
            if (booking.status === 'rider-otw' && booking.estimatedArrival) {
                const eta = new Date(booking.estimatedArrival);
                const now = new Date();
                const minutesLeft = Math.max(0, Math.floor((eta - now) / 60000));
                etaHtml = `
                    <div class="eta-badge mb-6">
                        <i class="fas fa-clock mr-2"></i>
                        Estimated Arrival: ${minutesLeft} minutes
                    </div>
                `;
            }

            // Content
            contentDiv.innerHTML = `
                ${etaHtml}
                
                <!-- Progress Bar -->
                <div class="mb-6">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: ${progress}%"></div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Pickup Location
                        </h4>
                        <p class="text-sm text-gray-600">${booking.pickupAddress}</p>
                        <p class="text-sm text-gray-600">${booking.pickupContact} - ${booking.pickupPhone}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>Delivery Location
                        </h4>
                        <p class="text-sm text-gray-600">${booking.deliveryAddress}</p>
                        <p class="text-sm text-gray-600">${booking.recipientName} - ${booking.recipientPhone}</p>
                    </div>
                </div>

                ${booking.riderName ? `
                    <!-- Rider Information -->
                    <div class="bg-orange-50 p-4 rounded-lg mb-6">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-motorcycle mr-2 text-orange-600"></i>Your Rider
                        </h4>
                        <div class="flex items-center space-x-4">
                            <img src="${booking.riderPicture}" alt="Rider photo" class="w-12 h-12 rounded-full object-cover" onerror="this.src='https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/72d8d825-1a5f-49e7-9046-15413073f494.png'">
                            <div>
                                <p class="font-medium">${booking.riderName}</p>
                                <p class="text-sm text-gray-600">⭐ ${booking.riderRating}</p>
                                <button onclick="callRider('${booking.riderPhone}')" class="text-orange-600 hover:text-orange-800 text-sm underline">
                                    ${booking.riderPhone}
                                </button>
                            </div>
                        </div>
                    </div>
                ` : ''}

                <!-- Timeline -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h4 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-history mr-2 text-gray-600"></i>Delivery Timeline
                    </h4>
                    <div class="tracking-line space-y-4">
                        ${booking.statusHistory.map((history, index) => `
                            <div class="tracking-step ${getTrackingStepClass(history.status, booking.status)}">
                                <div class="tracking-icon ${getTrackingIconClass(history.status, booking.status)}">
                                    ${getTrackingStepClass(history.status, booking.status).includes('completed') ? '<i class="fas fa-check"></i>' : ''}
                                </div>
                                <div>
                                    <p class="font-medium">${history.message}</p>
                                    <p class="text-xs text-gray-500">${new Date(history.timestamp).toLocaleString()}</p>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>

                ${booking.specialInstructions ? `
                    <div class="bg-yellow-50 p-4 rounded-lg mt-4">
                        <h4 class="font-semibold text-gray-800 mb-2">Special Instructions</h4>
                        <p class="text-sm text-gray-600">${booking.specialInstructions}</p>
                    </div>
                ` : ''}
            `;

            resultsDiv.classList.remove('hidden');
        }

        function getProgressPercentage(status) {
            const progressMap = {
                'pending': 10,
                'approved': 25,
                'rider-assigned': 50,
                'rider-otw': 75,
                'delivered': 100,
                'cancelled': 0
            };
            return progressMap[status] || 0;
        }

        function getTrackingStepClass(stepStatus, currentStatus) {
            const statusOrder = ['pending', 'approved', 'rider-assigned', 'rider-otw', 'delivered'];
            const stepIndex = statusOrder.indexOf(stepStatus);
            const currentIndex = statusOrder.indexOf(currentStatus);
            
            if (stepIndex < currentIndex) return 'completed';
            if (stepIndex === currentIndex) return 'current';
            return 'pending';
        }

        function getTrackingIconClass(stepStatus, currentStatus) {
            const stepClass = getTrackingStepClass(stepStatus, currentStatus);
            return stepClass;
        }

        function loadRecentOrders() {
            const recentOrdersDiv = document.getElementById('recentOrders');
            const recentBookings = bookings.slice(0, 5);
            
            if (recentBookings.length === 0) {
                recentOrdersDiv.innerHTML = '<p class="text-gray-500 text-center py-4">No recent orders</p>';
                return;
            }

            recentOrdersDiv.innerHTML = recentBookings.map(booking => `
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg cursor-pointer hover:bg-gray-100" onclick="document.getElementById('trackingInput').value='${booking.id}'; trackOrder();">
                    <div>
                        <p class="font-medium">${booking.itemName}</p>
                        <p class="text-sm text-gray-600">${booking.id} • ${new Date(booking.createdAt).toLocaleDateString()}</p>
                    </div>
                    <span class="status-badge status-${booking.status} text-xs">
                        ${booking.status.replace('-', ' ')}
                    </span>
                </div>
            `).join('');
        }

        function showBookingDetails(bookingId) {
            const booking = bookings.find(b => b.id === bookingId);
            if (!booking) return;

            displayTrackingResults(booking);
            
            // Show in modal format
            const detailsContent = document.getElementById('detailsContent');
            detailsContent.innerHTML = document.getElementById('trackingContent').innerHTML;
            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function callRider(phone) {
            if (confirm(`Call rider at ${phone}?`)) {
                window.open(`tel:${phone}`, '_self');
            }
        }

        // Dashboard functions
        function refreshDashboard() {
            updateDashboardStats();
            renderBookingsList();
            animateCounters();
        }

        function updateDashboardStats() {
            const pending = bookings.filter(b => b.status === 'pending').length;
            const approved = bookings.filter(b => b.status === 'approved').length;
            const assigned = bookings.filter(b => b.status === 'rider-assigned').length;
            const otw = bookings.filter(b => b.status === 'rider-otw').length;
            const delivered = bookings.filter(b => b.status === 'delivered').length;
            const totalEarnings = bookings.filter(b => b.status === 'delivered').reduce((sum, b) => sum + b.shippingFee, 0);

            document.getElementById('pendingCount').textContent = pending;
            document.getElementById('approvedCount').textContent = approved;
            document.getElementById('assignedCount').textContent = assigned;
            document.getElementById('otwCount').textContent = otw;
            document.getElementById('deliveredCount').textContent = delivered;
            document.getElementById('totalEarnings').textContent = '₱' + totalEarnings.toFixed(2);
            document.getElementById('deliveryCount').textContent = delivered;
        }

        function renderBookingsList() {
            const container = document.getElementById('bookingsList');
            const filter = document.getElementById('statusFilter')?.value || '';
            
            let filteredBookings = bookings;
            if (filter) {
                filteredBookings = bookings.filter(b => b.status === filter);
            }
            
            if (filteredBookings.length === 0) {
                container.innerHTML = `
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-inbox text-4xl mb-4"></i>
                        <p class="text-lg">${filter ? `No ${filter} bookings found.` : 'No bookings yet. Create your first booking to get started!'}</p>
                        ${!filter ? `<button onclick="showSection('booking')" class="mt-4 lalamove-gradient text-white px-6 py-2 rounded-lg hover:opacity-90 transition duration-300">Create Booking</button>` : ''}
                    </div>
                `;
                return;
            }

            container.innerHTML = filteredBookings.map(booking => `
                <div class="booking-card bg-gray-50 border border-gray-200 rounded-lg p-6 mb-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">${booking.itemName}</h4>
                            <p class="text-sm text-gray-600">${booking.itemCategory} • ID: ${booking.id}</p>
                        </div>
                        <div class="text-right">
                            <span class="status-badge status-${booking.status}">
                                <i class="fas fa-${getStatusIcon(booking.status)} mr-1"></i>
                                ${booking.status.replace('-', ' ').toUpperCase()}
                            </span>
                            <p class="text-lg font-bold text-gray-900 mt-1">₱${booking.shippingFee.toFixed(2)}</p>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <h5 class="font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Pickup & Delivery
                            </h5>
                            <p class="text-sm text-gray-600"><strong>From:</strong> ${booking.pickupAddress.substring(0, 30)}...</p>
                            <p class="text-sm text-gray-600"><strong>To:</strong> ${booking.deliveryAddress.substring(0, 30)}...</p>
                            <p class="text-sm text-gray-600"><strong>Distance:</strong> ${booking.distance}km</p>
                        </div>
                        <div>
                            <h5 class="font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-2 text-green-600"></i>Contact Information
                            </h5>
                            <p class="text-sm text-gray-600"><strong>Pickup:</strong> ${booking.pickupContact}</p>
                            <p class="text-sm text-gray-600"><strong>Recipient:</strong> ${booking.recipientName}</p>
                            ${booking.riderName ? `<p class="text-sm text-gray-600"><strong>Rider:</strong> ${booking.riderName}</p>` : ''}
                        </div>
                    </div>

                    ${booking.cancellationReason ? `
                        <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-700">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Cancelled:</strong> ${booking.cancellationReason}
                            </p>
                        </div>
                    ` : ''}

                    ${booking.status === 'rider-otw' && booking.estimatedArrival ? `
                        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-700">
                                <i class="fas fa-clock mr-2"></i>
                                <strong>ETA:</strong> ${Math.max(0, Math.floor((new Date(booking.estimatedArrival) - new Date()) / 60000))} minutes
                            </p>
                        </div>
                    ` : ''}
                    
                    <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            Created: ${new Date(booking.createdAt).toLocaleDateString()}
                        </div>
                        <div class="space-x-2">
                            <button onclick="showBookingDetails('${booking.id}')" class="text-gray-600 hover:text-gray-800 text-sm font-medium">
                                <i class="fas fa-eye mr-1"></i>Details
                            </button>
                            ${getBookingActions(booking)}
                            <button onclick="deleteBooking('${booking.id}')" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function getBookingActions(booking) {
            switch (booking.status) {
                case 'pending':
                    return `
                        <button onclick="approveBooking('${booking.id}')" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            <i class="fas fa-check mr-1"></i>Approve
                        </button>
                        <button onclick="rejectBooking('${booking.id}')" class="text-red-600 hover:text-red-800 text-sm font-medium">
                            <i class="fas fa-times mr-1"></i>Cancel
                        </button>
                    `;
                case 'approved':
                    return `
                        <button onclick="assignRider('${booking.id}')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-motorcycle mr-1"></i>Assign Rider
                        </button>
                    `;
                case 'rider-assigned':
                    return `
                        <button onclick="updateBookingStatus('${booking.id}', 'rider-otw')" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="fas fa-truck mr-1"></i>Start Delivery
                        </button>
                    `;
                case 'rider-otw':
                    return `
                        <button onclick="updateBookingStatus('${booking.id}', 'delivered')" class="text-green-600 hover:text-green-800 text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Mark Delivered
                        </button>
                    `;
                default:
                    return '';
            }
        }

        function getStatusIcon(status) {
            const icons = {
                'pending': 'clock',
                'approved': 'check-circle',
                'rider-assigned': 'user-check',
                'rider-otw': 'motorcycle',
                'delivered': 'check-double',
                'cancelled': 'times-circle'
            };
            return icons[status] || 'question-circle';
        }

        function filterBookings() {
            if (currentSection === 'dashboard') {
                renderBookingsList();
            }
        }

        // Admin quick actions
        function autoAssignRiders() {
            const approvedBookings = bookings.filter(b => b.status === 'approved');
            const availableRiders = riders.filter(r => r.status === 'available');
            
            let assigned = 0;
            for (let i = 0; i < Math.min(approvedBookings.length, availableRiders.length); i++) {
                assignRiderToBooking(approvedBookings[i].id, availableRiders[i]);
                assigned++;
            }
            
            showNotification('Auto Assignment', `${assigned} riders assigned automatically`, 'success');
        }

        function simulateRiderMovement() {
            const assignedBookings = bookings.filter(b => b.status === 'rider-assigned');
            
            assignedBookings.forEach(booking => {
                setTimeout(() => {
                    updateBookingStatus(booking.id, 'rider-otw');
                }, Math.random() * 5000);
            });
            
            showNotification('Simulation Started', 'Riders are now moving to pickup locations', 'info');
        }

        function markAllDelivered() {
            const otwBookings = bookings.filter(b => b.status === 'rider-otw');
            
            if (otwBookings.length === 0) {
                showNotification('No Orders', 'No orders are currently on the way', 'info');
                return;
            }
            
            if (confirm(`Mark ${otwBookings.length} orders as delivered?`)) {
                otwBookings.forEach(booking => {
                    updateBookingStatus(booking.id, 'delivered');
                    
                    // Free up the rider
                    const rider = riders.find(r => r.id === booking.riderId);
                    if (rider) {
                        rider.status = 'available';
                        delete rider.currentBooking;
                    }
                });
                
                localStorage.setItem('lalamoveRiders', JSON.stringify(riders));
                showNotification('Bulk Update', `${otwBookings.length} orders marked as delivered`, 'success');
            }
        }

        function deleteBooking(bookingId) {
            if (confirm('Are you sure you want to delete this booking?')) {
                // Free up rider if assigned
                const booking = bookings.find(b => b.id === bookingId);
                if (booking && booking.riderId) {
                    const rider = riders.find(r => r.id === booking.riderId);
                    if (rider) {
                        rider.status = 'available';
                        delete rider.currentBooking;
                        localStorage.setItem('lalamoveRiders', JSON.stringify(riders));
                    }
                }
                
                bookings = bookings.filter(b => b.id !== bookingId);
                localStorage.setItem('lalamoveBookings', JSON.stringify(bookings));
                refreshDashboard();
            }
        }

        function clearAllBookings() {
            if (confirm('Are you sure you want to delete all bookings? This action cannot be undone.')) {
                // Free up all riders
                riders.forEach(rider => {
                    rider.status = 'available';
                    delete rider.currentBooking;
                });
                localStorage.setItem('lalamoveRiders', JSON.stringify(riders));
                
                bookings = [];
                localStorage.setItem('lalamoveBookings', JSON.stringify(bookings));
                refreshDashboard();
            }
        }

        // Notification system
        function showNotification(title, message, type = 'info') {
            const notification = document.getElementById('notification');
            const icon = document.getElementById('notificationIcon');
            const titleEl = document.getElementById('notificationTitle');
            const messageEl = document.getElementById('notificationMessage');
            
            // Set content
            titleEl.textContent = title;
            messageEl.textContent = message;
            
            // Set styling based on type
            const colors = {
                'success': { bg: 'bg-green-100', text: 'text-green-600', icon: 'fa-check-circle' },
                'error': { bg: 'bg-red-100', text: 'text-red-600', icon: 'fa-exclamation-circle' },
                'info': { bg: 'bg-blue-100', text: 'text-blue-600', icon: 'fa-info-circle' }
            };
            
            const color = colors[type] || colors.info;
            icon.className = `w-10 h-10 rounded-full flex items-center justify-center ${color.bg}`;
            icon.innerHTML = `<i class="fas ${color.icon} text-xl ${color.text}"></i>`;
            
            // Show notification
            notification.classList.add('show');
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                hideNotification();
            }, 5000);
        }

        function hideNotification() {
            const notification = document.getElementById('notification');
            notification.classList.remove('show');
        }

        // Modal functions
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Animate counters
        function animateCounters() {
            const counters = document.querySelectorAll('#deliveryCount');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 30);
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Load bookings from localStorage
            bookings = JSON.parse(localStorage.getItem('lalamoveBookings')) || [];
            
            // Initialize dashboard stats
            updateDashboardStats();
            animateCounters();
            
            // Auto-progress some bookings for demo
            setTimeout(() => {
                autoProgressDemo();
            }, 2000);
        });

        // Demo auto-progression
        function autoProgressDemo() {
            // Randomly progress some bookings every 30 seconds
            setInterval(() => {
                const progressableBookings = bookings.filter(b => 
                    b.status === 'rider-assigned' || b.status === 'rider-otw'
                );
                
                if (progressableBookings.length > 0 && Math.random() < 0.3) {
                    const randomBooking = progressableBookings[Math.floor(Math.random() * progressableBookings.length)];
                    
                    if (randomBooking.status === 'rider-assigned') {
                        updateBookingStatus(randomBooking.id, 'rider-otw');
                    } else if (randomBooking.status === 'rider-otw') {
                        updateBookingStatus(randomBooking.id, 'delivered');
                        
                        // Free up the rider
                        const rider = riders.find(r => r.id === randomBooking.riderId);
                        if (rider) {
                            rider.status = 'available';
                            delete rider.currentBooking;
                            localStorage.setItem('lalamoveRiders', JSON.stringify(riders));
                        }
                    }
                }
            }, 30000);
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('mobileMenu');
            const menuButton = e.target.closest('button[onclick="toggleMobileMenu()"]');
            
            if (!menu.contains(e.target) && !menuButton && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });

        // Close modals when clicking outside
        document.addEventListener('click', function(e) {
            const modals = ['successModal', 'rejectModal', 'detailsModal', 'assignRiderModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (e.target === modal) {
                    closeModal(modalId);
                }
            });
        });

        // Allow tracking with Enter key
        document.getElementById('trackingInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                trackOrder();
            }
        });
    </script>
</body>
</html>

