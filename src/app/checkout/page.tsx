"use client";
import React, { useState, useEffect } from 'react';
import { useCart } from '@/lib/CartContext';
import { motion } from 'framer-motion';
import { MapPin, Phone, User, ArrowLeft, CreditCard, ShoppingBag, CheckCircle2 } from 'lucide-react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';

export default function CheckoutPage() {
  const { cart, subtotal, clearCart } = useCart();
  const router = useRouter();
  const [loading, setLoading] = useState(false);
  const [complete, setComplete] = useState(false);

  // Form states
  const [formData, setFormData] = useState({
    name: '',
    phone: '',
    address: '',
    paymentMethod: 'cod'
  });

  useEffect(() => {
    // Fill name if available
    const storedName = localStorage.getItem('user_name');
    if (storedName) {
      setFormData(prev => ({ ...prev, name: storedName }));
    }
  }, []);

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (cart.length === 0) return;

    setLoading(true);

    try {
      // Simulate API call to save order
      const response = await fetch('/api/orders', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          ...formData,
          items: cart,
          total: subtotal + 45,
        }),
      });

      if (response.ok) {
        setComplete(true);
        clearCart();
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

  if (complete) {
    return (
      <div className="min-h-[80vh] flex items-center justify-center p-4">
        <motion.div 
          initial={{ opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          className="bg-white rounded-[3rem] p-12 md:p-20 shadow-2xl border border-coffee-50 max-w-2xl w-full text-center"
        >
          <div className="bg-green-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-8">
            <CheckCircle2 className="h-12 w-12 text-green-600" />
          </div>
          <h1 className="text-4xl font-black text-coffee-950 mb-4 tracking-tight">Order Placed Successfully!</h1>
          <p className="text-coffee-500 text-lg mb-10 font-medium leading-relaxed">
            Thank you for your order! Our baristas are now preparing your fresh coffee. You can track your order in the "My Orders" section.
          </p>
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
    <div className="max-w-6xl mx-auto py-12 px-6">
      <div className="flex items-center space-x-4 mb-12">
        <Link href="/cart" className="p-3 bg-white border border-coffee-100 rounded-2xl hover:bg-cream-50 transition-all shadow-sm">
          <ArrowLeft className="h-5 w-5 text-coffee-900" />
        </Link>
        <div>
          <h1 className="text-4xl font-black text-coffee-950 leading-none">Checkout</h1>
          <p className="text-coffee-400 font-medium mt-1">Complete your order details</p>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
        {/* Left: Delivery Form */}
        <div>
          <form id="checkout-form" onSubmit={handleSubmit} className="space-y-8">
            <div className="bg-white p-10 rounded-[2.5rem] border border-coffee-50 shadow-sm space-y-8">
              <h2 className="text-2xl font-black text-coffee-950 flex items-center space-x-3">
                 <div className="w-10 h-10 bg-cream-50 rounded-xl flex items-center justify-center">
                    <MapPin className="h-5 w-5 text-[#C69276]" />
                 </div>
                 <span>Delivery Information</span>
              </h2>

              <div className="space-y-6">
                <div className="space-y-2">
                  <label className="text-[10px] font-black uppercase tracking-widest text-coffee-300 ml-1">Full Name</label>
                  <div className="relative">
                    <User className="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-200" />
                    <input 
                      required
                      type="text" 
                      name="name"
                      value={formData.name}
                      onChange={handleInputChange}
                      placeholder="e.g. John Doe"
                      className="w-full bg-cream-50/30 border border-coffee-50 rounded-2xl py-4 pl-12 pr-6 outline-none focus:ring-4 focus:ring-[#C69276]/10 transition-all"
                    />
                  </div>
                </div>

                <div className="space-y-2">
                  <label className="text-[10px] font-black uppercase tracking-widest text-coffee-300 ml-1">Contact Number</label>
                  <div className="relative">
                    <Phone className="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-coffee-200" />
                    <input 
                      required
                      type="tel" 
                      name="phone"
                      value={formData.phone}
                      onChange={handleInputChange}
                      placeholder="e.g. 09123456789"
                      className="w-full bg-cream-50/30 border border-coffee-50 rounded-2xl py-4 pl-12 pr-6 outline-none focus:ring-4 focus:ring-[#C69276]/10 transition-all"
                    />
                  </div>
                </div>

                <div className="space-y-2">
                  <label className="text-[10px] font-black uppercase tracking-widest text-coffee-300 ml-1">Delivery Address</label>
                  <div className="relative">
                    <MapPin className="absolute left-4 top-4 h-4 w-4 text-coffee-200" />
                    <textarea 
                      required
                      rows={3}
                      name="address"
                      value={formData.address}
                      onChange={handleInputChange}
                      placeholder="Street, Room/Floor, Landmark"
                      className="w-full bg-cream-50/30 border border-coffee-50 rounded-2xl py-4 pl-12 pr-6 outline-none focus:ring-4 focus:ring-[#C69276]/10 transition-all resize-none"
                    ></textarea>
                  </div>
                </div>
              </div>
            </div>

            <div className="bg-white p-10 rounded-[2.5rem] border border-coffee-50 shadow-sm space-y-6">
               <h2 className="text-2xl font-black text-coffee-950 flex items-center space-x-3">
                 <div className="w-10 h-10 bg-cream-50 rounded-xl flex items-center justify-center">
                    <CreditCard className="h-5 w-5 text-[#6366F1]" />
                 </div>
                 <span>Payment Method</span>
               </h2>

               <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <label className={`cursor-pointer border-2 p-6 rounded-2xl flex items-center space-x-4 transition-all ${formData.paymentMethod === 'cod' ? 'border-[#C69276] bg-[#C69276]/5' : 'border-coffee-50'}`}>
                    <input type="radio" name="paymentMethod" value="cod" checked={formData.paymentMethod === 'cod'} onChange={handleInputChange} className="hidden" />
                    <div className={`w-6 h-6 rounded-full border-2 flex items-center justify-center ${formData.paymentMethod === 'cod' ? 'border-[#C69276]' : 'border-coffee-200'}`}>
                        {formData.paymentMethod === 'cod' && <div className="w-3 h-3 bg-[#C69276] rounded-full"></div>}
                    </div>
                    <div>
                      <span className="block font-black text-coffee-950 uppercase text-xs tracking-widest">Cash on Delivery</span>
                      <span className="block text-xs text-coffee-400">Pay when you receive</span>
                    </div>
                  </label>

                  <label className={`cursor-pointer border-2 p-6 rounded-2xl flex items-center space-x-4 opacity-50 transition-all border-coffee-50`}>
                    <input type="radio" name="paymentMethod" value="gcash" disabled className="hidden" />
                    <div className="w-6 h-6 rounded-full border-2 border-coffee-100"></div>
                    <div>
                      <span className="block font-black text-coffee-950 uppercase text-xs tracking-widest">GCash</span>
                      <span className="block text-xs text-red-400">Unavailable</span>
                    </div>
                  </label>
               </div>
            </div>
          </form>
        </div>

        {/* Right: Order Summary */}
        <div className="space-y-8">
           <div className="bg-[#2D1B14] p-10 rounded-[3rem] text-white shadow-2xl">
              <h2 className="text-2xl font-black mb-8 italic uppercase tracking-widest">Our Selection</h2>
              
              <div className="space-y-6 mb-10 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
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

              <div className="space-y-4 border-t border-white/10 pt-8 mt-10">
                <div className="flex justify-between text-white/60 font-medium">
                  <span>Items Subtotal</span>
                  <span>₱{subtotal.toFixed(2)}</span>
                </div>
                <div className="flex justify-between text-white/60 font-medium">
                  <span>Shipping Fee</span>
                  <span>₱45.00</span>
                </div>
                <div className="flex justify-between text-3xl font-black pt-4 border-t border-white/5">
                  <span className="italic uppercase">Total</span>
                  <span className="text-[#D4A373]">₱{(subtotal + 45).toFixed(2)}</span>
                </div>
              </div>

              <button 
                form="checkout-form"
                type="submit"
                disabled={loading}
                className="w-full bg-[#D4A373] text-white py-6 rounded-2xl font-black text-xl hover:bg-[#B68A5D] transition-all shadow-2xl mt-10 active:scale-95 disabled:opacity-50 disabled:scale-100"
              >
                {loading ? 'Processing...' : 'CONFIRM ORDER'}
              </button>
              
              <p className="text-center text-white/30 text-[10px] mt-8 uppercase tracking-widest font-black">
                NextCafe • Premium Coffee Experience
              </p>
           </div>

           <div className="bg-cream-50 p-8 rounded-[2.5rem] border border-dashed border-coffee-100 text-center">
              <ShoppingBag className="h-8 w-8 text-coffee-200 mx-auto mb-4" />
              <p className="text-coffee-400 font-medium text-sm leading-relaxed px-6">
                Please double check your information and total amount before confirming your order.
              </p>
           </div>
        </div>
      </div>
    </div>
  );
}
