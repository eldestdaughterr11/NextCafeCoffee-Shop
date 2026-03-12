"use client";
import { Mail, Phone, MapPin, Send, Instagram, Facebook, Twitter } from "lucide-react";
import { motion } from "framer-motion";

export default function ContactPage() {
  return (
    <div className="pt-32 pb-20 px-4">
      <div className="max-w-7xl mx-auto">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-20">
          {/* Info */}
          <div>
            <h1 className="text-5xl font-bold text-coffee-950 mb-8">Get in Touch</h1>
            <p className="text-xl text-coffee-600 mb-12">
              Have questions or suggestions? We'd love to hear from you. Reach out through any of these channels.
            </p>

            <div className="space-y-8">
              {[
                { icon: MapPin, label: "Visit Us", value: "123 Coffee St. Manila, Philippines" },
                { icon: Phone, label: "Call Us", value: "+63 912 345 6789" },
                { icon: Mail, label: "Email Us", value: "hello@nextcafe.com" },
              ].map((item) => (
                <div key={item.label} className="flex items-center space-x-6">
                  <div className="bg-white p-4 rounded-2xl shadow-sm border border-coffee-50 text-coffee-600">
                    <item.icon className="h-6 w-6" />
                  </div>
                  <div>
                    <div className="text-xs font-bold text-coffee-400 uppercase tracking-widest">{item.label}</div>
                    <div className="text-lg font-bold text-coffee-900">{item.value}</div>
                  </div>
                </div>
              ))}
            </div>

            <div className="mt-16 flex space-x-6">
              {[Instagram, Facebook, Twitter].map((Icon, i) => (
                <a key={i} href="#" className="bg-coffee-950 p-4 rounded-full text-white hover:bg-coffee-600 transition-all">
                  <Icon className="h-6 w-6" />
                </a>
              ))}
            </div>
          </div>

          {/* Form */}
          <motion.div 
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            className="bg-white p-10 rounded-[3rem] shadow-xl border border-coffee-100"
          >
            <h2 className="text-2xl font-bold text-coffee-950 mb-8">Send a Message</h2>
            <form className="space-y-6">
              <div className="grid grid-cols-2 gap-6">
                <div>
                  <label className="block text-sm font-bold text-coffee-900 mb-2">Name</label>
                  <input type="text" className="w-full bg-cream-50/50 border border-coffee-100 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-coffee-100 focus:border-coffee-500 transition-all" />
                </div>
                <div>
                  <label className="block text-sm font-bold text-coffee-900 mb-2">Email</label>
                  <input type="email" className="w-full bg-cream-50/50 border border-coffee-100 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-coffee-100 focus:border-coffee-500 transition-all" />
                </div>
              </div>
              <div>
                <label className="block text-sm font-bold text-coffee-900 mb-2">Subject</label>
                <input type="text" className="w-full bg-cream-50/50 border border-coffee-100 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-coffee-100 focus:border-coffee-500 transition-all" />
              </div>
              <div>
                <label className="block text-sm font-bold text-coffee-900 mb-2">Message</label>
                <textarea rows={4} className="w-full bg-cream-50/50 border border-coffee-100 rounded-2xl p-4 outline-none focus:ring-2 focus:ring-coffee-100 focus:border-coffee-500 transition-all resize-none"></textarea>
              </div>
              <button className="w-full bg-coffee-900 text-white py-5 rounded-2xl font-bold hover:bg-coffee-800 transition-all shadow-lg flex items-center justify-center space-x-2">
                <span>Send Message</span>
                <Send className="h-5 w-5" />
              </button>
            </form>
          </motion.div>
        </div>
      </div>
    </div>
  );
}
