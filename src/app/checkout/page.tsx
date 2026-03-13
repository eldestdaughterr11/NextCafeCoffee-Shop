"use client";
import React, { useState, useEffect } from 'react';
import { useCart } from '@/lib/CartContext';
import { motion } from 'framer-motion';
import { MapPin, Phone, User, ArrowLeft, ArrowRight, ShoppingBag, Truck } from 'lucide-react';
import { useRouter } from 'next/navigation';
import Link from 'next/link';

export default function CheckoutPage() {
  const { cart, subtotal } = useCart();
  const router = useRouter();

  // Form states
  const [formData, setFormData] = useState({
    name: '',
    phone: '',
    address: '',
  });
  const [userEmail, setUserEmail] = useState<string | null>(null);
  const checkoutKey = `nextcafe-checkout-${userEmail || 'guest'}`;

  useEffect(() => {
    const email = localStorage.getItem('user_email');
    setUserEmail(email);

    const storedName = localStorage.getItem('user_name');
    if (storedName) {
      setFormData(prev => ({ ...prev, name: storedName }));
    }
  }, []);

  // Separate effect to load saved data once key is ready
  useEffect(() => {
    if (!userEmail) {
       const email = localStorage.getItem('user_email');
       if (email) setUserEmail(email);
    }
    const saved = localStorage.getItem(checkoutKey);
    if (saved) {
      try {
        const parsed = JSON.parse(saved);
        setFormData(prev => ({ ...prev, ...parsed }));
      } catch {}
    }
  }, [userEmail, checkoutKey]);

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleNext = (e: React.FormEvent) => {
    e.preventDefault();
    // Save form data to localStorage for next steps
    localStorage.setItem(checkoutKey, JSON.stringify(formData));
    router.push('/delivery');
  };

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
        <Link href="/cart" className="p-3 bg-white border border-coffee-100 rounded-2xl hover:bg-cream-50 transition-all shadow-sm">
          <ArrowLeft className="h-5 w-5 text-coffee-900" />
        </Link>
        <div>
          <h1 className="text-4xl font-black text-coffee-950 leading-none">Checkout</h1>
          <p className="text-coffee-400 font-medium mt-1">Step 1 of 3 — Fill in your details</p>
        </div>
      </div>

      {/* Progress Bar */}
      <div className="mb-10 md:mb-12">
        <div className="flex items-center justify-between max-w-lg mx-auto md:mx-0">
          <div className="flex flex-col items-center">
            <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-[#C69276] text-white flex items-center justify-center font-black text-base md:text-lg shadow-lg shadow-[#C69276]/30">1</div>
            <span className="text-[10px] md:text-xs font-black text-[#C69276] mt-2 uppercase tracking-widest text-center">Details</span>
          </div>
          <div className="flex-1 h-1 bg-coffee-100 mx-2 md:mx-4 rounded-full overflow-hidden">
            <div className="h-full w-0 bg-[#C69276] rounded-full"></div>
          </div>
          <div className="flex flex-col items-center">
            <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-coffee-100 text-coffee-300 flex items-center justify-center font-black text-base md:text-lg">2</div>
            <span className="text-[10px] md:text-xs font-bold text-coffee-300 mt-2 uppercase tracking-widest text-center">Delivery</span>
          </div>
          <div className="flex-1 h-1 bg-coffee-100 mx-2 md:mx-4 rounded-full"></div>
          <div className="flex flex-col items-center">
            <div className="w-10 h-10 md:w-12 md:h-12 rounded-full bg-coffee-100 text-coffee-300 flex items-center justify-center font-black text-base md:text-lg">3</div>
            <span className="text-[10px] md:text-xs font-bold text-coffee-300 mt-2 uppercase tracking-widest text-center">Payment</span>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-16">
        {/* Left: Form */}
        <div>
          <form onSubmit={handleNext} className="space-y-8">
            <motion.div 
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              className="bg-white p-6 md:p-10 rounded-[2.5rem] border border-coffee-50 shadow-sm space-y-8"
            >
              <h2 className="text-2xl font-black text-coffee-950 flex items-center space-x-3">
                <div className="w-10 h-10 bg-cream-50 rounded-xl flex items-center justify-center">
                  <User className="h-5 w-5 text-[#C69276]" />
                </div>
                <span>Your Information</span>
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
                      placeholder="e.g. Juan Dela Cruz"
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
                      placeholder="Street, Building, Room/Floor, Landmark"
                      className="w-full bg-cream-50/30 border border-coffee-50 rounded-2xl py-4 pl-12 pr-6 outline-none focus:ring-4 focus:ring-[#C69276]/10 transition-all resize-none"
                    ></textarea>
                  </div>
                </div>
              </div>
            </motion.div>

            <motion.button 
              initial={{ opacity: 0, y: 10 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 0.2 }}
              type="submit"
              className="w-full bg-[#C69276] text-white py-6 rounded-2xl font-black text-xl hover:bg-[#B68A5D] transition-all shadow-2xl shadow-[#C69276]/20 active:scale-95 flex items-center justify-center space-x-3"
            >
              <span>PROCEED TO DELIVERY</span>
              <ArrowRight className="h-6 w-6" />
            </motion.button>
          </form>
        </div>

        {/* Right: Order Summary */}
        <div className="space-y-8">
          <motion.div 
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            className="bg-[#2D1B14] p-6 md:p-10 rounded-[3rem] text-white shadow-2xl"
          >
            <h2 className="text-2xl font-black mb-8 italic uppercase tracking-widest">Your Order</h2>
            
            <div className="space-y-6 mb-10 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
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
                  <Truck className="h-4 w-4" />
                  <span>Lalamove Shipping</span>
                </span>
                <span className="text-coffee-300 italic">Next step</span>
              </div>
              <div className="flex justify-between text-2xl font-black pt-4 border-t border-white/5">
                <span className="italic uppercase">Subtotal</span>
                <span className="text-[#D4A373]">₱{subtotal.toFixed(2)}</span>
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
