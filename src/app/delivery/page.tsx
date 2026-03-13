"use client";
import React, { useState, useEffect } from 'react';
import { useCart } from '@/lib/CartContext';
import { motion } from 'framer-motion';
import { ArrowLeft, ArrowRight, Truck, Navigation, MapPin, Clock, Shield, Package, Store } from 'lucide-react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';

// Lalamove-style distance-based fee
const shippingRates = [
  { maxKm: 2, fee: 39, label: '0-2 km', eta: '15-20 min' },
  { maxKm: 5, fee: 59, label: '2-5 km', eta: '20-30 min' },
  { maxKm: 10, fee: 89, label: '5-10 km', eta: '30-45 min' },
  { maxKm: 20, fee: 129, label: '10-20 km', eta: '45-60 min' },
  { maxKm: 999, fee: 179, label: '20+ km', eta: '60-90 min' },
];

// Common FEU Tech area locations
const presetLocations = [
  { name: 'FEU Tech (P. Paredes)', distance: 0.5 },
  { name: 'UST Area', distance: 1.2 },
  { name: 'España Blvd', distance: 1.5 },
  { name: 'Quiapo / Recto', distance: 2.5 },
  { name: 'Cubao, QC', distance: 7 },
  { name: 'Makati CBD', distance: 10 },
  { name: 'BGC, Taguig', distance: 13 },
  { name: 'Las Piñas / Muntinlupa', distance: 22 },
  { name: 'Other Location', distance: -1 },
];

export default function DeliveryPage() {
  const { cart, subtotal } = useCart();
  const router = useRouter();

  const [deliveryMethod, setDeliveryMethod] = useState('delivery'); // 'delivery' or 'pickup'
  const [selectedLocation, setSelectedLocation] = useState('');
  const [customDistance, setCustomDistance] = useState('');
  const [shippingFee, setShippingFee] = useState(0);
  const [currentEta, setCurrentEta] = useState('');

  // Check if checkout data exists
  useEffect(() => {
    const checkout = localStorage.getItem('nextcafe-checkout');
    if (!checkout && cart.length > 0) {
      router.push('/checkout');
    }
    // Load saved delivery data if coming back from payment
    const saved = localStorage.getItem('nextcafe-delivery');
    if (saved) {
      try {
        const parsed = JSON.parse(saved);
        setDeliveryMethod(parsed.deliveryMethod || 'delivery');
        setSelectedLocation(parsed.selectedLocation || '');
        setCustomDistance(parsed.customDistance || '');
      } catch {}
    }
  }, []);

  // Calculate shipping fee based on distance
  useEffect(() => {
    if (deliveryMethod === 'pickup') {
      setShippingFee(0);
      setCurrentEta('Ready in 15 mins');
      return;
    }

    const loc = presetLocations.find(l => l.name === selectedLocation);
    if (!loc) {
      setShippingFee(0);
      setCurrentEta('');
      return;
    }

    let distance = loc.distance;
    if (distance === -1 && customDistance) {
      distance = parseFloat(customDistance);
    }
    if (distance < 0 || isNaN(distance)) {
      setShippingFee(0);
      setCurrentEta('');
      return;
    }

    const rate = shippingRates.find(r => distance <= r.maxKm);
    setShippingFee(rate?.fee || 179);
    setCurrentEta(rate?.eta || '60-90 min');
  }, [selectedLocation, customDistance, deliveryMethod]);

  const handleNext = () => {
    if (deliveryMethod === 'delivery' && shippingFee === 0) return;
    // Save delivery data
    localStorage.setItem('nextcafe-delivery', JSON.stringify({
      deliveryMethod,
      selectedLocation: deliveryMethod === 'delivery' ? selectedLocation : '',
      customDistance: deliveryMethod === 'delivery' ? customDistance : '',
      shippingFee,
    }));
    router.push('/payment');
  };

  if (cart.length === 0) {
    return (
      <div className="min-h-[80vh] flex items-center justify-center">
        <div className="text-center">
          <Package className="mx-auto h-16 w-16 text-coffee-100 mb-6" />
          <h2 className="text-2xl font-bold text-coffee-950 mb-4">Your cart is empty</h2>
          <Link href="/menu" className="text-[#C69276] font-bold hover:underline">Back to Menu</Link>
        </div>
      </div>
    );
  }

  return (
    <div className="max-w-6xl mx-auto py-8 md:py-12 px-4 md:px-6">
      {/* Header */}
      <div className="flex items-center space-x-4 mb-8">
        <Link href="/checkout" className="p-3 bg-white border border-coffee-100 rounded-2xl hover:bg-cream-50 transition-all shadow-sm">
          <ArrowLeft className="h-5 w-5 text-coffee-900" />
        </Link>
        <div>
          <h1 className="text-4xl font-black text-coffee-950 leading-none">Delivery</h1>
          <p className="text-coffee-400 font-medium mt-1">Step 2 of 3 — Lalamove Shipping</p>
        </div>
      </div>

      {/* Progress Bar */}
      <div className="mb-10 md:mb-12">
        <div className="flex items-center justify-between max-w-lg mx-auto md:mx-0">
          <div className="flex flex-col items-center">
            <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-green-600 text-white flex items-center justify-center font-black text-base md:text-lg shadow-lg">✓</div>
            <span className="text-[10px] md:text-xs font-black text-green-600 mt-2 uppercase tracking-widest text-center">Details</span>
          </div>
          <div className="flex-1 h-1 bg-[#C69276] mx-2 md:mx-4 rounded-full"></div>
          <div className="flex flex-col items-center">
            <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-[#C69276] text-white flex items-center justify-center font-black text-base md:text-lg shadow-lg shadow-[#C69276]/30">2</div>
            <span className="text-[10px] md:text-xs font-black text-[#C69276] mt-2 uppercase tracking-widest text-center">Delivery</span>
          </div>
          <div className="flex-1 h-1 bg-coffee-100 mx-2 md:mx-4 rounded-full"></div>
          <div className="flex flex-col items-center">
            <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-coffee-100 text-coffee-300 flex items-center justify-center font-black text-base md:text-lg">3</div>
            <span className="text-[10px] md:text-xs font-bold text-coffee-300 mt-2 uppercase tracking-widest text-center">Payment</span>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
        {/* Left: Delivery Selection */}
        <div className="space-y-8">
          {/* Method Selection */}
          <div className="grid grid-cols-2 gap-4">
            <button
              onClick={() => setDeliveryMethod('delivery')}
              className={`p-6 rounded-3xl border-2 flex flex-col items-center justify-center space-y-3 transition-all ${
                deliveryMethod === 'delivery' 
                ? 'border-orange-500 bg-orange-50 text-orange-600 shadow-xl shadow-orange-500/10' 
                : 'border-coffee-100 bg-white text-coffee-400 hover:bg-cream-50'
              }`}
            >
              <Truck className="h-8 w-8" />
              <span className="font-bold">Delivery</span>
            </button>
            <button
              onClick={() => setDeliveryMethod('pickup')}
              className={`p-6 rounded-3xl border-2 flex flex-col items-center justify-center space-y-3 transition-all ${
                deliveryMethod === 'pickup' 
                ? 'border-green-500 bg-green-50 text-green-600 shadow-xl shadow-green-500/10' 
                : 'border-coffee-100 bg-white text-coffee-400 hover:bg-cream-50'
              }`}
            >
              <Store className="h-8 w-8" />
              <span className="font-bold">Pick-up</span>
            </button>
          </div>

          {deliveryMethod === 'delivery' ? (
            <>
              {/* Lalamove Partner Badge */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="bg-gradient-to-br from-orange-500 to-orange-600 p-6 md:p-8 rounded-[2.5rem] text-white shadow-2xl shadow-orange-500/20 relative overflow-hidden"
          >
            <div className="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-x-10 -translate-y-10"></div>
            <div className="absolute bottom-0 left-0 w-24 h-24 bg-white/5 rounded-full translate-x-[-30%] translate-y-[30%]"></div>
            <div className="relative z-10">
              <div className="flex items-center space-x-4 mb-4">
                <div className="w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-lg">
                  <Truck className="h-7 w-7 text-orange-500" />
                </div>
                <div>
                  <h3 className="text-2xl font-black">Lalamove</h3>
                  <p className="text-sm text-orange-100 font-medium">Official Delivery Partner</p>
                </div>
              </div>
              <p className="text-orange-100 text-sm leading-relaxed">
                Fast, reliable, and affordable delivery straight to your doorstep. Real-time tracking included!
              </p>
            </div>
          </motion.div>

          {/* Location Selection */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.1 }}
            className="bg-white p-6 md:p-10 rounded-[2.5rem] border border-coffee-50 shadow-sm space-y-6"
          >
            <h2 className="text-2xl font-black text-coffee-950 flex items-center space-x-3">
              <div className="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center">
                <MapPin className="h-5 w-5 text-orange-500" />
              </div>
              <span>Select Delivery Area</span>
            </h2>

            <p className="text-sm text-coffee-400 leading-relaxed">
              Choose your area below to calculate the Lalamove delivery fee. We deliver from our NextCafe branch near <span className="font-bold text-coffee-700">FEU Tech, Manila</span>.
            </p>

            <div className="space-y-2">
              <label className="text-[10px] font-black uppercase tracking-widest text-coffee-300 ml-1">Your Area</label>
              <div className="relative">
                <Navigation className="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-orange-400" />
                <select
                  required
                  value={selectedLocation}
                  onChange={(e) => setSelectedLocation(e.target.value)}
                  className="w-full appearance-none bg-cream-50/30 border border-coffee-50 rounded-2xl py-4 pl-12 pr-6 outline-none focus:ring-4 focus:ring-orange-100 transition-all cursor-pointer font-medium text-coffee-800"
                >
                  <option value="">— Pin your location —</option>
                  {presetLocations.map(loc => (
                    <option key={loc.name} value={loc.name}>
                      📍 {loc.name} {loc.distance > 0 ? `(~${loc.distance} km)` : ''}
                    </option>
                  ))}
                </select>
              </div>
            </div>

            {selectedLocation === 'Other Location' && (
              <motion.div 
                initial={{ opacity: 0, height: 0 }}
                animate={{ opacity: 1, height: 'auto' }}
                className="space-y-2"
              >
                <label className="text-[10px] font-black uppercase tracking-widest text-coffee-300 ml-1">Estimated Distance (km)</label>
                <input
                  type="number"
                  min="0"
                  step="0.5"
                  value={customDistance}
                  onChange={(e) => setCustomDistance(e.target.value)}
                  placeholder="e.g. 8"
                  className="w-full bg-cream-50/30 border border-coffee-50 rounded-2xl py-4 px-6 outline-none focus:ring-4 focus:ring-orange-100 transition-all"
                />
              </motion.div>
            )}

            {shippingFee > 0 && (
              <motion.div 
                initial={{ opacity: 0, scale: 0.95 }}
                animate={{ opacity: 1, scale: 1 }}
                className="bg-orange-50 border-2 border-orange-200 rounded-2xl p-6 space-y-4"
              >
                <div className="flex items-center justify-between">
                  <div className="flex items-center space-x-3">
                    <Truck className="h-6 w-6 text-orange-500" />
                    <div>
                      <span className="font-black text-coffee-800 text-lg">Delivery Fee</span>
                      <p className="text-xs text-coffee-400">via Lalamove</p>
                    </div>
                  </div>
                  <span className="font-black text-orange-600 text-2xl">₱{shippingFee.toFixed(2)}</span>
                </div>
                {currentEta && (
                  <div className="flex items-center space-x-2 text-sm bg-white rounded-xl p-3">
                    <Clock className="h-4 w-4 text-orange-400" />
                    <span className="text-coffee-600 font-medium">Estimated delivery: <span className="font-black text-orange-600">{currentEta}</span></span>
                  </div>
                )}
              </motion.div>
            )}
          </motion.div>

          {/* Rate Table */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.2 }}
            className="bg-white p-6 md:p-8 rounded-[2.5rem] border border-coffee-50 shadow-sm"
          >
            <h3 className="text-sm font-black uppercase tracking-widest text-coffee-950 mb-6 flex items-center space-x-2">
              <Shield className="h-4 w-4 text-orange-500" />
              <span>Lalamove Rate Table</span>
            </h3>
            <div className="space-y-2">
              {shippingRates.map(r => (
                <div key={r.label} className={`flex items-center justify-between py-3 px-4 rounded-xl transition-all ${
                  shippingFee === r.fee ? 'bg-orange-50 border-2 border-orange-200' : 'hover:bg-cream-50'
                }`}>
                  <div className="flex items-center space-x-3">
                    <div className={`w-2 h-2 rounded-full ${shippingFee === r.fee ? 'bg-orange-500' : 'bg-coffee-200'}`}></div>
                    <span className="text-coffee-600 font-medium text-sm">{r.label}</span>
                  </div>
                  <div className="flex items-center space-x-4">
                    <span className="text-xs text-coffee-400">{r.eta}</span>
                    <span className={`font-black text-sm ${shippingFee === r.fee ? 'text-orange-600' : 'text-coffee-700'}`}>₱{r.fee}</span>
                  </div>
                </div>
              ))}
            </div>
          </motion.div>
          </>) : (
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="bg-green-50 p-8 rounded-[2.5rem] border border-green-200 text-center"
            >
              <div className="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <Store className="h-10 w-10 text-green-600" />
              </div>
              <h3 className="text-2xl font-black text-green-800 mb-2">Pick-up at Store</h3>
              <p className="text-green-600 font-medium">Free of charge. Ready in 15 minutes.</p>
              <p className="text-sm text-green-600/70 mt-4">NextCafe Branch, FEU Tech, Manila</p>
            </motion.div>
          )}

          {/* Action Buttons */}
          <motion.div
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.3 }}
            className="flex gap-4"
          >
            <Link href="/checkout" className="flex-shrink-0 bg-white border-2 border-coffee-100 text-coffee-700 py-5 px-8 rounded-2xl font-black hover:bg-cream-50 transition-all flex items-center space-x-2">
              <ArrowLeft className="h-5 w-5" />
              <span>Back</span>
            </Link>
            <button 
              onClick={handleNext}
              disabled={deliveryMethod === 'delivery' && shippingFee === 0}
              className="flex-grow bg-[#C69276] text-white py-6 rounded-2xl font-black text-xl hover:bg-[#B68A5D] transition-all shadow-2xl shadow-[#C69276]/20 active:scale-95 flex items-center justify-center space-x-3 disabled:opacity-50 disabled:scale-100"
            >
              <span>PROCEED TO PAYMENT</span>
              <ArrowRight className="h-6 w-6" />
            </button>
          </motion.div>
        </div>

        {/* Right: Order Summary */}
        <div>
          <motion.div 
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            className="bg-[#2D1B14] p-6 md:p-10 rounded-[3rem] text-white shadow-2xl sticky top-8"
          >
            <h2 className="text-2xl font-black mb-8 italic uppercase tracking-widest">Your Order</h2>
            
            <div className="space-y-6 mb-10 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">
              {cart.map((item) => (
                <div key={item.id} className="flex items-center justify-between group">
                  <div className="flex items-center space-x-4">
                    <div className="w-12 h-12 rounded-xl overflow-hidden bg-white/10 flex-shrink-0">
                      <img src={item.image} alt={item.name} className="w-full h-full object-cover" />
                    </div>
                    <div>
                      <p className="font-bold text-sm text-white group-hover:text-[#D4A373] transition-colors">{item.name}</p>
                      <p className="text-xs text-white/40">Qty: {item.quantity}</p>
                    </div>
                  </div>
                  <span className="font-bold text-white/90 italic">₱{(item.price * item.quantity).toFixed(2)}</span>
                </div>
              ))}
            </div>

            <div className="space-y-4 border-t border-white/10 pt-8">
              <div className="flex justify-between text-white/60 font-medium">
                <span>Items Subtotal</span>
                <span>₱{subtotal.toFixed(2)}</span>
              </div>
              <div className="flex justify-between text-white/60 font-medium">
                <span className="flex items-center space-x-2">
                  {deliveryMethod === 'delivery' ? <Truck className="h-4 w-4 text-orange-400" /> : <Store className="h-4 w-4 text-green-400" />}
                  <span>{deliveryMethod === 'delivery' ? 'Lalamove Shipping' : 'Store Pick-up'}</span>
                </span>
                <span className={shippingFee > 0 ? 'text-orange-400 font-bold' : 'text-green-400 font-bold'}>
                  {deliveryMethod === 'delivery' ? (shippingFee > 0 ? `₱${shippingFee.toFixed(2)}` : '—') : 'FREE'}
                </span>
              </div>
              <div className="flex justify-between text-2xl font-black pt-4 border-t border-white/5">
                <span className="italic uppercase">Total</span>
                <span className="text-[#D4A373]">₱{(subtotal + shippingFee).toFixed(2)}</span>
              </div>
            </div>
            
            <p className="text-center text-white/30 text-[10px] mt-8 uppercase tracking-widest font-black">
              NextCafe • Powered by GCash & Lalamove
            </p>
          </motion.div>
        </div>
      </div>
    </div>
  );
}
