"use client";
import React, { useState, useEffect } from 'react';
import { useCart } from '@/lib/CartContext';
import { motion } from 'framer-motion';
import { ArrowLeft, Truck, CheckCircle2, ShoppingBag, Smartphone, Copy, Check } from 'lucide-react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';

export default function PaymentPage() {
  const { cart, subtotal, clearCart } = useCart();
  const router = useRouter();
  const [loading, setLoading] = useState(false);
  const [complete, setComplete] = useState(false);
  const [gcashRef, setGcashRef] = useState('');
  const [copied, setCopied] = useState(false);

  const [shippingFee, setShippingFee] = useState(0);
  const [checkoutData, setCheckoutData] = useState<any>(null);

  // Load checkout + delivery data
  useEffect(() => {
    const checkout = localStorage.getItem('nextcafe-checkout');
    const delivery = localStorage.getItem('nextcafe-delivery');
    
    if (!checkout || !delivery) {
      if (cart.length > 0) {
        router.push('/checkout');
      }
      return;
    }
    
    try {
      setCheckoutData(JSON.parse(checkout));
      const deliveryData = JSON.parse(delivery);
      setShippingFee(deliveryData.shippingFee || 0);
    } catch {}
  }, []);

  const total = subtotal + shippingFee;

  const copyNumber = () => {
    navigator.clipboard.writeText('09123456789');
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (cart.length === 0 || !gcashRef) return;

    setLoading(true);

    try {
      const response = await fetch('/api/orders', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          ...checkoutData,
          gcashRef,
          paymentMethod: 'gcash',
          items: cart,
          shippingFee,
          total,
        }),
      });

      if (response.ok) {
        setComplete(true);
        clearCart();
        // Clean up localStorage
        localStorage.removeItem('nextcafe-checkout');
        localStorage.removeItem('nextcafe-delivery');
      } else {
        alert('Failed to place order. Please try again.');
      }
    } catch (err) {
      console.error(err);
      alert('An error occurred.');
    } finally {
      setLoading(false);
    }
  };

  // Order Complete Screen
  if (complete) {
    return (
      <div className="min-h-[80vh] flex items-center justify-center p-4">
        <motion.div 
          initial={{ opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          className="bg-white rounded-[3rem] p-12 md:p-20 shadow-2xl border border-coffee-50 max-w-2xl w-full text-center"
        >
          <motion.div 
            initial={{ scale: 0 }}
            animate={{ scale: 1 }}
            transition={{ type: "spring", delay: 0.2 }}
            className="bg-green-100 w-28 h-28 rounded-full flex items-center justify-center mx-auto mb-8"
          >
            <CheckCircle2 className="h-14 w-14 text-green-600" />
          </motion.div>
          <h1 className="text-4xl font-black text-coffee-950 mb-4 tracking-tight">Order Placed Successfully!</h1>
          <p className="text-coffee-500 text-lg mb-4 font-medium leading-relaxed">
            Thank you for your GCash payment! Our baristas are now preparing your fresh coffee.
          </p>
          <p className="text-coffee-400 text-sm mb-10">Your order will be delivered via <span className="font-bold text-orange-500">Lalamove</span>. Track it in "My Orders".</p>
          <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
            <Link href="/dashboard" className="w-full sm:w-auto bg-coffee-950 text-white px-10 py-5 rounded-2xl font-black transition-all hover:bg-coffee-800 shadow-xl">
              Go to Dashboard
            </Link>
            <Link href="/orders" className="w-full sm:w-auto bg-cream-100 text-[#C69276] px-10 py-5 rounded-2xl font-black transition-all hover:bg-cream-200">
              View My Orders
            </Link>
          </div>
        </motion.div>
      </div>
    );
  }

  if (cart.length === 0) {
    return (
      <div className="min-h-[80vh] flex items-center justify-center">
        <div className="text-center">
          <ShoppingBag className="mx-auto h-16 w-16 text-coffee-100 mb-6" />
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
        <Link href="/delivery" className="p-3 bg-white border border-coffee-100 rounded-2xl hover:bg-cream-50 transition-all shadow-sm">
          <ArrowLeft className="h-5 w-5 text-coffee-900" />
        </Link>
        <div>
          <h1 className="text-4xl font-black text-coffee-950 leading-none">Payment</h1>
          <p className="text-coffee-400 font-medium mt-1">Step 3 of 3 — Pay via GCash</p>
        </div>
      </div>

      {/* Progress Bar */}
      <div className="mb-10 md:mb-12">
        <div className="flex items-center justify-between max-w-lg mx-auto md:mx-0">
          <div className="flex flex-col items-center">
            <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-green-600 text-white flex items-center justify-center font-black text-base md:text-lg shadow-lg">✓</div>
            <span className="text-[10px] md:text-xs font-black text-green-600 mt-2 uppercase tracking-widest text-center">Details</span>
          </div>
          <div className="flex-1 h-1 bg-green-500 mx-2 md:mx-4 rounded-full"></div>
          <div className="flex flex-col items-center">
            <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-green-600 text-white flex items-center justify-center font-black text-base md:text-lg shadow-lg">✓</div>
            <span className="text-[10px] md:text-xs font-black text-green-600 mt-2 uppercase tracking-widest text-center">Delivery</span>
          </div>
          <div className="flex-1 h-1 bg-[#007DFE] mx-2 md:mx-4 rounded-full"></div>
          <div className="flex flex-col items-center">
            <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-[#007DFE] text-white flex items-center justify-center font-black text-base md:text-lg shadow-lg shadow-[#007DFE]/30">3</div>
            <span className="text-[10px] md:text-xs font-black text-[#007DFE] mt-2 uppercase tracking-widest text-center">Payment</span>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
        {/* Left: GCash Payment */}
        <div className="space-y-8">
          {/* GCash Header Card */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            className="bg-gradient-to-br from-[#007DFE] to-[#0055CC] p-6 md:p-8 rounded-[2.5rem] text-white shadow-2xl shadow-[#007DFE]/20 relative overflow-hidden"
          >
            <div className="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -translate-x-10 -translate-y-20"></div>
            <div className="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-x-[-40%] translate-y-[40%]"></div>
            <div className="relative z-10 flex items-center space-x-5">
              <div className="w-20 h-20 bg-white rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0 overflow-hidden">
                <img src="/images/gcash-logo.png" alt="GCash" className="w-14 h-14 object-contain" />
              </div>
              <div>
                <h3 className="text-3xl font-black">GCash Payment</h3>
                <p className="text-blue-100 font-medium mt-1">Fast, secure, and cashless</p>
              </div>
            </div>
          </motion.div>

          {/* Payment Instructions */}
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.1 }}
            className="bg-white p-6 md:p-10 rounded-[2.5rem] border border-coffee-50 shadow-sm space-y-6"
          >
            <h2 className="text-2xl font-black text-coffee-950 flex items-center space-x-3">
              <div className="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                <Smartphone className="h-5 w-5 text-[#007DFE]" />
              </div>
              <span>How to Pay</span>
            </h2>

            {/* Steps */}
            <div className="space-y-4">
              <div className="flex items-start space-x-4">
                <div className="w-8 h-8 bg-[#007DFE]/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                  <span className="text-[#007DFE] font-black text-sm">1</span>
                </div>
                <div>
                  <p className="font-bold text-coffee-800">Open GCash App</p>
                  <p className="text-sm text-coffee-400">Open your GCash app and tap "Send Money"</p>
                </div>
              </div>
              <div className="flex items-start space-x-4">
                <div className="w-8 h-8 bg-[#007DFE]/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                  <span className="text-[#007DFE] font-black text-sm">2</span>
                </div>
                <div>
                  <p className="font-bold text-coffee-800">Send Payment</p>
                  <p className="text-sm text-coffee-400">Send the exact amount to our GCash number</p>
                </div>
              </div>
              <div className="flex items-start space-x-4">
                <div className="w-8 h-8 bg-[#007DFE]/10 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                  <span className="text-[#007DFE] font-black text-sm">3</span>
                </div>
                <div>
                  <p className="font-bold text-coffee-800">Enter Reference</p>
                  <p className="text-sm text-coffee-400">Enter the GCash reference number below</p>
                </div>
              </div>
            </div>

            {/* GCash Number */}
            <div className="bg-[#007DFE]/5 border-2 border-[#007DFE]/20 rounded-2xl p-6 space-y-4">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-xs text-coffee-400 font-medium">Send money to</p>
                  <p className="text-3xl font-black text-[#007DFE] mt-1">0912 345 6789</p>
                  <p className="text-xs text-coffee-400 mt-1">Account: <span className="font-bold">NextCafe Coffee Shop</span></p>
                </div>
                <button 
                  onClick={copyNumber}
                  className="p-3 bg-[#007DFE]/10 rounded-xl hover:bg-[#007DFE]/20 transition-all"
                >
                  {copied ? <Check className="h-5 w-5 text-green-500" /> : <Copy className="h-5 w-5 text-[#007DFE]" />}
                </button>
              </div>

              <div className="bg-white border border-[#007DFE]/10 rounded-xl p-4 text-center">
                <p className="text-xs text-coffee-400 font-medium">Amount to Send</p>
                <p className="text-3xl font-black text-[#007DFE]">₱{total.toFixed(2)}</p>
              </div>
            </div>

            {/* Reference Number Input */}
            <form onSubmit={handleSubmit} id="payment-form">
              <div className="space-y-2">
                <label className="text-[10px] font-black uppercase tracking-widest text-coffee-300 ml-1">GCash Reference Number</label>
                <input
                  required
                  type="text"
                  value={gcashRef}
                  onChange={(e) => setGcashRef(e.target.value)}
                  placeholder="e.g. 1234 5678 9012"
                  className="w-full bg-white border-2 border-[#007DFE]/20 rounded-2xl py-4 px-6 outline-none focus:ring-4 focus:ring-[#007DFE]/10 transition-all font-bold text-lg tracking-wider"
                />
              </div>
            </form>

            <p className="text-xs text-coffee-400 text-center">
              🔒 Secure payment via GCash — the most popular e-wallet in the Philippines
            </p>
          </motion.div>

          {/* Action Buttons */}
          <motion.div
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.2 }}
            className="flex gap-4"
          >
            <Link href="/delivery" className="flex-shrink-0 bg-white border-2 border-coffee-100 text-coffee-700 py-5 px-8 rounded-2xl font-black hover:bg-cream-50 transition-all flex items-center space-x-2">
              <ArrowLeft className="h-5 w-5" />
              <span>Back</span>
            </Link>
            <button 
              form="payment-form"
              type="submit"
              disabled={loading || !gcashRef}
              className="flex-grow bg-[#007DFE] text-white py-6 rounded-2xl font-black text-xl hover:bg-[#0066CC] transition-all shadow-2xl shadow-[#007DFE]/20 active:scale-95 flex items-center justify-center space-x-3 disabled:opacity-50 disabled:scale-100"
            >
              <img src="/images/gcash-logo.png" alt="" className="h-6 w-6 object-contain rounded" />
              <span>{loading ? 'Processing...' : 'CONFIRM & PAY VIA GCASH'}</span>
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
                  <Truck className="h-4 w-4 text-orange-400" />
                  <span>Lalamove Shipping</span>
                </span>
                <span className="text-orange-400 font-bold">₱{shippingFee.toFixed(2)}</span>
              </div>
              <div className="flex justify-between text-white/60 font-medium">
                <span className="flex items-center space-x-2">
                  <img src="/images/gcash-logo.png" alt="GCash" className="h-4 w-4 object-contain rounded" />
                  <span>Payment</span>
                </span>
                <span className="text-[#007DFE] font-bold">GCash</span>
              </div>
              <div className="flex justify-between text-3xl font-black pt-4 border-t border-white/5">
                <span className="italic uppercase">Total</span>
                <span className="text-[#D4A373]">₱{total.toFixed(2)}</span>
              </div>
            </div>
            
            <p className="text-center text-white/30 text-[10px] mt-8 uppercase tracking-widest font-black">
              NextCafe • Powered by GCash & Lalamove
            </p>
          </motion.div>

          <div className="bg-cream-50 p-8 rounded-[2.5rem] border border-dashed border-coffee-100 text-center mt-8">
            <ShoppingBag className="h-8 w-8 text-coffee-200 mx-auto mb-4" />
            <p className="text-coffee-400 font-medium text-sm leading-relaxed px-6">
              Make sure you&apos;ve sent the correct GCash amount and entered the reference number before confirming.
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}
